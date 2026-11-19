<?php

namespace App\Http\Controllers;

use App\Models\AssessmentPeriod;
use App\Models\DocumentVerification;
use App\Models\Supervisor;
use App\Models\TeacherDocument;
use App\Notifications\DocumentVerificationNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengawasDocumentController extends Controller
{
    private function getSupervisor(): Supervisor
    {
        $user = Auth::user();

        abort_if(!$user, 403, 'Anda harus login terlebih dahulu.');

        $supervisor = Supervisor::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->first();

        abort_if(
            !$supervisor,
            403,
            'Data pengawas aktif belum terhubung dengan akun Anda.'
        );

        return $supervisor;
    }

    /**
     * Daftar dokumen guru binaan dengan filter periode dan arsip.
     */
    public function index(Request $request): View
    {
        $supervisor = $this->getSupervisor();

        $periods = AssessmentPeriod::query()
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get();

        // Periode aktif menjadi pilihan utama.
        // Jika tidak ada periode aktif, gunakan periode terbaru.
        $currentPeriod = AssessmentPeriod::query()
            ->where('status', 'active')
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->first();

        if (!$currentPeriod) {
            $currentPeriod = AssessmentPeriod::query()
                ->orderByDesc('start_date')
                ->orderByDesc('id')
                ->first();
        }

        $isArchive = $request->boolean('arsip');
        $academicYear = $request->query('academic_year');
        $semester = $request->query('semester');

        $query = TeacherDocument::query()
            ->with([
                'teacher',
                'documentType',
                'assessmentPeriod',
                'verifications' => function ($query) {
                    $query->latest('verified_at')->latest('id');
                },
            ])
            ->whereHas('teacher', function ($query) use ($supervisor) {
                $query->where('school_id', $supervisor->school_id);
            });

        if ($isArchive) {
            // Arsip berisi dokumen dari periode selain periode utama,
            // termasuk dokumen yang belum memiliki periode.
            if ($currentPeriod) {
                $query->where(function ($query) use ($currentPeriod) {
                    $query->whereNull('assessment_period_id')
                        ->orWhere('assessment_period_id', '!=', $currentPeriod->id);
                });
            }

            $query->whereIn('status', [
                'pending',
                'verified',
                'rejected',
            ]);
        } else {
            // Daftar utama hanya menampilkan dokumen pending dan verified.
            $query->whereIn('status', ['pending', 'verified']);

            // Jika tidak ada filter tahun/semester yang dipilih,
            // tampilkan periode utama secara default.
            if (
                !$request->filled('academic_year') &&
                !$request->filled('semester') &&
                $currentPeriod
            ) {
                $query->where(
                    'assessment_period_id',
                    $currentPeriod->id
                );
            }
        }

        // Filter tahun ajaran.
        if ($request->filled('academic_year')) {
            $query->whereHas('assessmentPeriod', function ($periodQuery) use ($academicYear) {
                $periodQuery->where('academic_year', $academicYear);
            });
        }

        // Filter semester.
        if ($request->filled('semester')) {
            $query->whereHas('assessmentPeriod', function ($periodQuery) use ($semester) {
                $periodQuery->where('semester', $semester);
            });
        }

        $documents = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        // Statistik tetap dibatasi pada sekolah binaan pengawas.
        $schoolDocuments = TeacherDocument::query()
            ->whereHas('teacher', function ($query) use ($supervisor) {
                $query->where('school_id', $supervisor->school_id);
            });

        $pendingCount = (clone $schoolDocuments)
            ->where('status', 'pending')
            ->count();

        $verifiedCount = (clone $schoolDocuments)
            ->where('status', 'verified')
            ->count();

        return view('pengawas.documents.index', compact(
            'supervisor',
            'documents',
            'periods',
            'currentPeriod',
            'isArchive',
            'academicYear',
            'semester',
            'pendingCount',
            'verifiedCount'
        ));
    }

    /**
     * Menampilkan detail dokumen.
     */
    public function show(TeacherDocument $teacherDocument): View
    {
        $supervisor = $this->getSupervisor();

        $teacherDocument->load([
            'teacher',
            'documentType',
            'assessmentPeriod',
            'verifications' => function ($query) {
                $query->latest('verified_at')->latest('id');
            },
        ]);

        $this->authorizeDocument($teacherDocument, $supervisor);

        return view('pengawas.documents.show', [
            'supervisor' => $supervisor,
            'document' => $teacherDocument,
        ]);
    }

    /**
     * Memverifikasi dokumen atau memperbarui verifikasi sebelumnya.
     */
    public function verify(
        Request $request,
        TeacherDocument $teacherDocument
    ): RedirectResponse {
        $supervisor = $this->getSupervisor();

        $teacherDocument->load([
            'teacher.user',
            'documentType',
        ]);

        $this->authorizeDocument($teacherDocument, $supervisor);

        if (!in_array($teacherDocument->status, ['pending', 'verified'], true)) {
            return redirect()
                ->route('pengawas.documents.index')
                ->with('error', 'Status dokumen tidak dapat diverifikasi.');
        }

        if (!$teacherDocument->documentType) {
            return back()->with(
                'error',
                'Jenis dokumen tidak ditemukan.'
            );
        }

        $maxScore = (float) $teacherDocument->documentType->max_score;

        $validated = $request->validate([
            'score' => [
                'required',
                'numeric',
                'min:0',
                'max:' . $maxScore,
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ], [
            'score.required' => 'Nilai dokumen wajib diisi.',
            'score.numeric' => 'Nilai dokumen harus berupa angka.',
            'score.min' => 'Nilai dokumen tidak boleh kurang dari 0.',
            'score.max' => 'Nilai dokumen tidak boleh melebihi ' . $maxScore . '.',
            'notes.max' => 'Catatan maksimal 2000 karakter.',
        ]);

        try {
            DB::transaction(function () use (
                $teacherDocument,
                $supervisor,
                $validated
            ) {
                $document = TeacherDocument::whereKey($teacherDocument->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!in_array($document->status, ['pending', 'verified'], true)) {
                    throw new \RuntimeException(
                        'Status dokumen sudah berubah dan tidak dapat diverifikasi.'
                    );
                }

                $documentType = $document->documentType;

                if (!$documentType) {
                    throw new \RuntimeException(
                        'Jenis dokumen tidak ditemukan.'
                    );
                }

                $currentMaxScore = (float) $documentType->max_score;
                $score = (float) $validated['score'];

                if ($score < 0 || $score > $currentMaxScore) {
                    throw new \RuntimeException(
                        'Nilai harus berada di antara 0 dan '
                        . $currentMaxScore . '.'
                    );
                }

                // Perilaku verifikasi lama dipertahankan:
                // perbarui verifikasi terbaru milik pengawas ini,
                // atau buat catatan baru jika belum tersedia.
                $verification = DocumentVerification::where(
                    'teacher_document_id',
                    $document->id
                )
                    ->where('supervisor_id', $supervisor->id)
                    ->latest('verified_at')
                    ->latest('id')
                    ->first();

                if ($verification) {
                    $verification->update([
                        'status' => 'verified',
                        'score' => $score,
                        'notes' => $validated['notes'] ?? null,
                        'verified_at' => now(),
                    ]);
                } else {
                    DocumentVerification::create([
                        'teacher_document_id' => $document->id,
                        'supervisor_id' => $supervisor->id,
                        'status' => 'verified',
                        'score' => $score,
                        'notes' => $validated['notes'] ?? null,
                        'verified_at' => now(),
                    ]);
                }

                $document->update([
                    'status' => 'verified',
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('GAGAL MEMVERIFIKASI DOKUMEN', [
                'message' => $e->getMessage(),
                'teacher_document_id' => $teacherDocument->id,
                'supervisor_id' => $supervisor->id,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Dokumen gagal diverifikasi: ' . $e->getMessage());
        }

        try {
            $teacher = $teacherDocument->teacher;

            if ($teacher && $teacher->user) {
                $teacher->user->notify(
                    new DocumentVerificationNotification(
                        $teacherDocument,
                        'verified',
                        $validated['notes'] ?? null
                    )
                );
            }
        } catch (\Throwable $e) {
            Log::warning('NOTIFIKASI VERIFIKASI DOKUMEN GAGAL', [
                'message' => $e->getMessage(),
                'teacher_document_id' => $teacherDocument->id,
            ]);
        }

        return redirect()
            ->route('pengawas.documents.show', $teacherDocument)
            ->with('success', 'Verifikasi dan nilai dokumen berhasil diperbarui.');
    }

    /**
     * Menolak dokumen tanpa menghapus record atau file.
     */
    public function reject(
        Request $request,
        TeacherDocument $teacherDocument
    ): RedirectResponse {
        $supervisor = $this->getSupervisor();

        $teacherDocument->load([
            'teacher.user',
            'documentType',
        ]);

        $this->authorizeDocument($teacherDocument, $supervisor);

        if ($teacherDocument->status !== 'pending') {
            return redirect()
                ->route('pengawas.documents.index')
                ->with('error', 'Hanya dokumen yang menunggu pemeriksaan yang dapat ditolak.');
        }

        $validated = $request->validate([
            'notes' => ['required', 'string', 'max:2000'],
        ], [
            'notes.required' => 'Alasan penolakan wajib diisi.',
            'notes.max' => 'Alasan penolakan maksimal 2000 karakter.',
        ]);

        try {
            DB::transaction(function () use (
                $teacherDocument,
                $supervisor,
                $validated
            ) {
                $document = TeacherDocument::whereKey($teacherDocument->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($document->status !== 'pending') {
                    throw new \RuntimeException(
                        'Dokumen sudah diproses dan tidak dapat ditolak.'
                    );
                }

                DocumentVerification::create([
                    'teacher_document_id' => $document->id,
                    'supervisor_id' => $supervisor->id,
                    'status' => 'rejected',
                    'score' => null,
                    'notes' => $validated['notes'],
                    'verified_at' => now(),
                ]);

                // Pertahankan record dan file untuk kebutuhan arsip.
                // Jangan memanggil delete() pada dokumen atau file.
                $document->update([
                    'status' => 'rejected',
                ]);
            });
        } catch (\Throwable $e) {
            Log::error('GAGAL MENOLAK DOKUMEN', [
                'message' => $e->getMessage(),
                'teacher_document_id' => $teacherDocument->id,
                'supervisor_id' => $supervisor->id,
            ]);

            return back()
                ->withInput()
                ->with('error', 'Dokumen gagal ditolak. Periksa log aplikasi.');
        }

        try {
            $teacher = $teacherDocument->teacher;

            if ($teacher && $teacher->user) {
                $teacher->user->notify(
                    new DocumentVerificationNotification(
                        $teacherDocument,
                        'rejected',
                        $validated['notes']
                    )
                );
            }
        } catch (\Throwable $e) {
            Log::warning('NOTIFIKASI PENOLAKAN DOKUMEN GAGAL', [
                'message' => $e->getMessage(),
                'teacher_document_id' => $teacherDocument->id,
            ]);
        }

        return redirect()
            ->route('pengawas.documents.index', ['arsip' => 1])
            ->with('success', 'Dokumen ditolak. Dokumen dan file tetap tersimpan di arsip.');
    }

    /**
     * Download dokumen.
     */
    public function download(TeacherDocument $teacherDocument)
    {
        $supervisor = $this->getSupervisor();

        $teacherDocument->load('teacher');

        $this->authorizeDocument($teacherDocument, $supervisor);

        abort_unless(
            $teacherDocument->file_path &&
            Storage::disk('public')->exists($teacherDocument->file_path),
            404,
            'File dokumen tidak ditemukan.'
        );

        return response()->download(
            Storage::disk('public')->path($teacherDocument->file_path),
            $teacherDocument->original_name
        );
    }

    /**
     * Memastikan dokumen berasal dari sekolah binaan pengawas.
     */
    private function authorizeDocument(
        TeacherDocument $teacherDocument,
        Supervisor $supervisor
    ): void {
        abort_unless(
            $teacherDocument->teacher &&
            (int) $teacherDocument->teacher->school_id ===
                (int) $supervisor->school_id,
            403,
            'Anda tidak memiliki akses ke dokumen ini.'
        );
    }
}
