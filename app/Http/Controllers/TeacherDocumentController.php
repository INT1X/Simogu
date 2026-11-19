<?php

namespace App\Http\Controllers;

use App\Models\AssessmentPeriod;
use App\Models\DocumentType;
use App\Models\TeacherDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Throwable;

class TeacherDocumentController extends Controller
{
    /**
     * Daftar dokumen guru yang sedang login.
     */
    public function index(Request $request): View
    {
        $teacher = Auth::user()->teacher;

        abort_if(
            !$teacher,
            403,
            'Data guru tidak ditemukan.'
        );

        // Daftar periode untuk filter tahun ajaran dan semester.
        $periods = AssessmentPeriod::query()
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get();

        // Periode aktif untuk menentukan daftar utama.
        $activePeriod = AssessmentPeriod::query()
            ->where('status', 'active')
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->first();

        // Ambil periode pilihan pengguna, jika tersedia.
        $selectedPeriodId = $request->query('period');

        $selectedPeriod = null;

        if (
            $selectedPeriodId !== null &&
            $selectedPeriodId !== ''
        ) {
            $selectedPeriod = $periods->firstWhere(
                'id',
                (int) $selectedPeriodId
            );

            // Abaikan ID periode yang tidak valid.
            if (!$selectedPeriod) {
                $selectedPeriodId = null;
            }
        }

        // Dokumen selalu dibatasi berdasarkan guru yang login.
        $documentsQuery = TeacherDocument::query()
            ->with([
                'documentType',
                'assessmentPeriod',
            ])
            ->where('teacher_id', $teacher->id);

        // Filter berdasarkan periode jika pengguna memilihnya.
        if ($selectedPeriod) {
            $documentsQuery->where(
                'assessment_period_id',
                $selectedPeriod->id
            );
        }

        // Filter berdasarkan status dokumen.
        $status = $request->query('status');

        if (
            in_array(
                $status,
                ['pending', 'verified', 'rejected'],
                true
            )
        ) {
            $documentsQuery->where('status', $status);
        } else {
            $status = '';
        }

        $documents = $documentsQuery
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        // Statistik berdasarkan seluruh dokumen milik guru,
        // tidak terpengaruh filter halaman.
        $statistics = TeacherDocument::query()
            ->where('teacher_id', $teacher->id)
            ->selectRaw('COUNT(*) AS total')
            ->selectRaw(
                "SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending"
            )
            ->selectRaw(
                "SUM(CASE WHEN status = 'verified' THEN 1 ELSE 0 END) AS verified"
            )
            ->selectRaw(
                "SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) AS rejected"
            )
            ->first();

        // Jenis dokumen yang masih aktif untuk unggahan baru.
        $documentTypes = DocumentType::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        // Jumlah dokumen pada periode aktif.
        $activePeriodDocumentCount = 0;

        if ($activePeriod) {
            $activePeriodDocumentCount = TeacherDocument::query()
                ->where('teacher_id', $teacher->id)
                ->where(
                    'assessment_period_id',
                    $activePeriod->id
                )
                ->count();
        }

        return view(
            'guru.documents.index',
            compact(
                'teacher',
                'periods',
                'activePeriod',
                'selectedPeriod',
                'selectedPeriodId',
                'status',
                'documents',
                'documentTypes',
                'statistics',
                'activePeriodDocumentCount'
            )
        );
    }

    /**
     * Menyimpan dokumen yang diunggah guru.
     */
    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        abort_if(
            !$teacher,
            403,
            'Data guru tidak ditemukan.'
        );

        $validated = $request->validate([
            'document_type_id' => [
                'required',
                'integer',
                'exists:document_types,id',
            ],

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ]);

        // Pilih periode aktif yang paling baru jika ternyata
        // terdapat lebih dari satu periode berstatus active.
        $assessmentPeriod = AssessmentPeriod::query()
            ->where('status', 'active')
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->first();

        if (!$assessmentPeriod) {
            return redirect()
                ->route('guru.documents.index')
                ->with(
                    'error',
                    'Unggahan dokumen belum dapat dilakukan karena tidak ada periode penilaian yang aktif.'
                );
        }

        // Pastikan jenis dokumen masih aktif.
        $documentType = DocumentType::query()
            ->whereKey($validated['document_type_id'])
            ->where('is_active', true)
            ->exists();

        if (!$documentType) {
            return redirect()
                ->route('guru.documents.index')
                ->withErrors([
                    'document_type_id' =>
                        'Jenis dokumen tidak tersedia atau sudah tidak aktif.',
                ])
                ->withInput();
        }

        $file = $request->file('file');
        $path = null;

        try {
            DB::transaction(function () use (
                $teacher,
                $assessmentPeriod,
                $validated,
                $file,
                &$path
            ) {
                // Simpan file ke disk public.
                $path = $file->store(
                    'teacher-documents',
                    'public'
                );

                if (!$path) {
                    throw new \RuntimeException(
                        'File gagal disimpan.'
                    );
                }

                TeacherDocument::create([
                    'teacher_id' => $teacher->id,

                    'document_type_id' =>
                        $validated['document_type_id'],

                    'assessment_period_id' =>
                        $assessmentPeriod->id,

                    'title' => $validated['title'],

                    'file_path' => $path,

                    'original_name' =>
                        $file->getClientOriginalName(),

                    'mime_type' =>
                        $file->getClientMimeType(),

                    'file_size' => $file->getSize(),

                    'status' => 'pending',
                ]);
            });
        } catch (Throwable $e) {
            // Hapus file jika penyimpanan database gagal.
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            report($e);

            return redirect()
                ->route('guru.documents.index')
                ->with(
                    'error',
                    'Dokumen gagal disimpan. Silakan coba kembali.'
                )
                ->withInput();
        }

        return redirect()
            ->route('guru.documents.index')
            ->with(
                'success',
                'Dokumen berhasil diunggah dan menunggu verifikasi.'
            );
    }
}