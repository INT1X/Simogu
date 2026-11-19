<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentComponentDetail;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentPeriod;
use App\Models\AssessmentWeight;
use App\Models\DocumentType;
use App\Models\Supervisor;
use App\Models\Teacher;
use App\Models\TeacherDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PengawasAssessmentController extends Controller
{
    /**
     * Mengambil data pengawas yang terhubung dengan akun login.
     */
    private function getSupervisor(): Supervisor
    {
        $user = Auth::user();

        abort_if(
            !$user,
            403,
            'Anda harus login terlebih dahulu.'
        );

        $supervisor = Supervisor::with('school')
            ->where('user_id', $user->id)
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
     * Mengambil periode penilaian yang aktif.
     */
    private function getActiveAssessmentPeriod(): AssessmentPeriod
    {
        $period = AssessmentPeriod::where(
            'status',
            'active'
        )->first();

        abort_if(
            !$period,
            422,
            'Tidak ada periode penilaian yang aktif.'
        );

        return $period;
    }

    /**
     * Kompetensi yang wajib dinilai.
     */
    private function requiredCompetencies(): array
    {
        return [
            'Pedagogik',
            'Kepribadian',
            'Sosial',
            'Profesional',
        ];
    }

    /**
     * Menghitung nilai dokumen yang telah diverifikasi.
     *
     * Dokumen harus sesuai dengan guru, pengawas, dan periode.
     * Nilai dokumen tidak ditambahkan ke final_score.
     */
    private function calculateDocumentScore(
        int $teacherId,
        int $supervisorId,
        int $assessmentPeriodId
    ): float {
        $documents = TeacherDocument::with([
            'documentType',
            'verifications' => function ($query) use ($supervisorId) {
                $query->where('supervisor_id', $supervisorId)
                    ->where('status', 'verified')
                    ->whereNotNull('score')
                    ->orderByDesc('verified_at')
                    ->orderByDesc('id');
            },
        ])
            ->where('teacher_id', $teacherId)
            ->where('assessment_period_id', $assessmentPeriodId)
            ->get();

        $scores = [];

        foreach ($documents as $document) {
            $verification = $document->verifications->first();
            $maxScore = $document->documentType?->max_score;

            if (
                !$verification ||
                !is_numeric($maxScore) ||
                (float) $maxScore <= 0
            ) {
                continue;
            }

            $score = (float) $verification->score;

            $score = max(
                0,
                min($score, (float) $maxScore)
            );

            $scores[] = ($score / (float) $maxScore) * 100;
        }

        if (empty($scores)) {
            return 0.0;
        }

        return round(
            array_sum($scores) / count($scores),
            2
        );
    }

    /**
     * Menghitung rata-rata kompetensi dan nilai akhir berbobot.
     *
     * Nilai akhir hanya berasal dari empat kompetensi.
     */
    private function calculateScores(array $scores): array
    {
        $indicators = AssessmentIndicator::where('is_active', true)
            ->orderBy('competency')
            ->orderBy('code')
            ->get();

        if ($indicators->isEmpty()) {
            throw ValidationException::withMessages([
                'scores' => 'Belum ada indikator penilaian aktif.',
            ]);
        }

        $weights = AssessmentWeight::where('is_active', true)
            ->get()
            ->keyBy('competency');

        $averages = [];

        foreach ($this->requiredCompetencies() as $competency) {
            $competencyIndicators = $indicators->where(
                'competency',
                $competency
            );

            if ($competencyIndicators->isEmpty()) {
                throw ValidationException::withMessages([
                    'scores' => "Indikator kompetensi {$competency} belum tersedia.",
                ]);
            }

            if (!$weights->has($competency)) {
                throw ValidationException::withMessages([
                    'scores' => "Bobot kompetensi {$competency} belum tersedia.",
                ]);
            }

            $weight = $weights->get($competency);

            if (
                !is_numeric($weight->weight) ||
                (float) $weight->weight < 0
            ) {
                throw ValidationException::withMessages([
                    'scores' => "Bobot kompetensi {$competency} tidak valid.",
                ]);
            }

            $indicatorScores = [];

            foreach ($competencyIndicators as $indicator) {
                if (!array_key_exists($indicator->id, $scores)) {
                    throw ValidationException::withMessages([
                        'scores' => "Semua indikator kompetensi {$competency} wajib dinilai.",
                    ]);
                }

                $indicatorScores[] = (float) $scores[$indicator->id];
            }

            $averages[$competency] = array_sum($indicatorScores)
                / count($indicatorScores);
        }

        $totalWeight = 0;

        foreach ($this->requiredCompetencies() as $competency) {
            $totalWeight += (float) $weights->get($competency)->weight;
        }

        if (abs($totalWeight - 100) > 0.01) {
            throw ValidationException::withMessages([
                'scores' => 'Total bobot empat kompetensi harus 100%. Periksa pengaturan bobot admin.',
            ]);
        }

        $finalScore = 0;

        foreach ($this->requiredCompetencies() as $competency) {
            $finalScore += $averages[$competency]
                * ((float) $weights->get($competency)->weight / 100);
        }

        return [
            'averages' => $averages,
            'final_score' => round($finalScore, 2),
            'indicators' => $indicators,
        ];
    }

    /**
     * Memvalidasi ID indikator dan kelengkapan seluruh nilai.
     */
    private function validateIndicatorScores(
        array $scores,
        $indicators
    ): void {
        $validIds = $indicators
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        foreach (array_keys($scores) as $id) {
            if (!in_array((string) $id, $validIds, true)) {
                throw ValidationException::withMessages([
                    'scores' => 'Indikator penilaian tidak valid atau sudah tidak aktif.',
                ]);
            }
        }

        foreach ($indicators as $indicator) {
            if (!array_key_exists($indicator->id, $scores)) {
                throw ValidationException::withMessages([
                    'scores' => "Indikator {$indicator->name} wajib dinilai.",
                ]);
            }

            if (
                !is_numeric($scores[$indicator->id]) ||
                (float) $scores[$indicator->id] < 0 ||
                (float) $scores[$indicator->id] > 100
            ) {
                throw ValidationException::withMessages([
                    'scores' => "Nilai indikator {$indicator->name} harus antara 0 sampai 100.",
                ]);
            }
        }
    }

    /**
     * Menampilkan daftar guru dan status penilaian
     * berdasarkan periode aktif.
     */
    public function index(): View
    {
        $supervisor = $this->getSupervisor();

        $assessmentPeriod = AssessmentPeriod::where(
            'status',
            'active'
        )->first();

        $teachers = Teacher::with('school')
            ->where('school_id', $supervisor->school_id)
            ->where('status', 'aktif')
            ->latest()
            ->get();

        $assessments = collect();

        if ($assessmentPeriod) {
            $assessments = Assessment::with([
                'teacher',
                'details.indicator',
                'assessmentPeriod',
            ])
                ->where('supervisor_id', $supervisor->id)
                ->whereIn('teacher_id', $teachers->pluck('id'))
                ->where(
                    'assessment_period_id',
                    $assessmentPeriod->id
                )
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get();
        }

        // Gunakan penilaian terbaru per guru dalam periode aktif.
        $assessmentByTeacher = $assessments
            ->unique('teacher_id')
            ->keyBy('teacher_id');

        $teachers->each(function ($teacher) use ($assessmentByTeacher) {
            $assessment = $assessmentByTeacher->get($teacher->id);

            if (!$assessment) {
                $teacher->assessment_status = 'not_started';
            } elseif ($assessment->status === 'completed') {
                $teacher->assessment_status = 'completed';
            } else {
                $teacher->assessment_status = 'draft';
            }

            $teacher->assessment = $assessment;
        });

        return view(
            'pengawas.assessments.index',
            compact(
                'supervisor',
                'teachers',
                'assessments',
                'assessmentPeriod'
            )
        );
    }

    /**
     * Menampilkan formulir penilaian untuk guru dalam sekolah binaan.
     *
     * Jika penilaian periode aktif sudah selesai, arahkan ke form edit
     * agar tidak membuat penilaian kedua untuk guru yang sama.
     */
    public function create(Request $request): View|RedirectResponse
    {
        $supervisor = $this->getSupervisor();
        $teacherId = $request->query('teacher_id');

        abort_if(
            !$teacherId,
            404,
            'Guru yang akan dinilai tidak ditemukan.'
        );

        $teacher = Teacher::with('school')
            ->where('id', $teacherId)
            ->where('school_id', $supervisor->school_id)
            ->where('status', 'aktif')
            ->first();

        abort_if(
            !$teacher,
            403,
            'Guru bukan bagian dari sekolah binaan Anda.'
        );

        $assessmentPeriod = AssessmentPeriod::where(
            'status',
            'active'
        )->first();

        $assessment = null;

        if ($assessmentPeriod) {
            $assessment = Assessment::with([
                'details.indicator',
                'assessmentPeriod',
            ])
                ->where('teacher_id', $teacher->id)
                ->where('supervisor_id', $supervisor->id)
                ->where(
                    'assessment_period_id',
                    $assessmentPeriod->id
                )
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->first();

            // Penilaian yang sudah selesai diarahkan ke halaman edit.
            if ($assessment && $assessment->status === 'completed') {
                return redirect()->route(
                    'pengawas.assessments.edit',
                    $assessment
                )->with(
                    'info',
                    'Penilaian pada periode aktif sudah selesai. Anda sedang membuka penilaian yang sudah ada.'
                );
            }
        }

        $indicators = AssessmentIndicator::where('is_active', true)
            ->orderBy('competency')
            ->orderBy('code')
            ->get();

        $indicatorsByCompetency = $indicators->groupBy('competency');

        $weights = AssessmentWeight::where('is_active', true)
            ->orderBy('competency')
            ->get()
            ->keyBy('competency');

        $documentTypes = DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'pengawas.assessments.create',
            compact(
                'supervisor',
                'teacher',
                'assessment',
                'indicators',
                'indicatorsByCompetency',
                'weights',
                'documentTypes',
                'assessmentPeriod'
            )
        );
    }

    /**
     * Menyimpan draft atau menyelesaikan penilaian.
     *
     * Draft dalam periode aktif diperbarui.
     * Penilaian selesai tidak dibuat ulang dalam periode yang sama.
     * Periode lama tidak dipindahkan otomatis ke periode aktif.
     */
    public function store(Request $request): RedirectResponse
    {
        $supervisor = $this->getSupervisor();

        $action = $request->input('action', 'draft');

        if (!in_array($action, ['draft', 'complete'], true)) {
            abort(422, 'Aksi penilaian tidak valid.');
        }

        $validated = $request->validate([
            'teacher_id' => [
                'required',
                'integer',
                'exists:teachers,id',
            ],
            'assessment_date' => [
                'required',
                'date',
            ],
            'scores' => [
                'required',
                'array',
                'min:1',
            ],
            'scores.*' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'notes' => [
                'nullable',
                'array',
            ],
            'notes.*' => [
                'nullable',
                'string',
            ],
        ]);

        $teacher = Teacher::where('id', $validated['teacher_id'])
            ->where('school_id', $supervisor->school_id)
            ->where('status', 'aktif')
            ->first();

        if (!$teacher) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Guru bukan bagian dari sekolah binaan Anda.'
                );
        }

        $assessmentPeriod = AssessmentPeriod::where(
            'status',
            'active'
        )->first();

        if (!$assessmentPeriod) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Tidak ada periode penilaian yang aktif. Aktifkan periode terlebih dahulu.'
                );
        }

        try {
            $result = $this->calculateScores($validated['scores']);

            $this->validateIndicatorScores(
                $validated['scores'],
                $result['indicators']
            );

            $status = $action === 'complete'
                ? 'completed'
                : 'draft';

            $assessment = DB::transaction(function () use (
                $validated,
                $teacher,
                $supervisor,
                $assessmentPeriod,
                $result,
                $status
            ) {
                /*
                 * Cari penilaian dalam periode aktif saja.
                 * Penilaian periode sebelumnya tidak diubah.
                 */
                $existingAssessment = Assessment::where(
                    'teacher_id',
                    $teacher->id
                )
                    ->where('supervisor_id', $supervisor->id)
                    ->where(
                        'assessment_period_id',
                        $assessmentPeriod->id
                    )
                    ->orderByDesc('created_at')
                    ->orderByDesc('id')
                    ->lockForUpdate()
                    ->first();

                /*
                 * Jika penilaian periode ini sudah selesai,
                 * jangan membuat penilaian duplikat.
                 * Gunakan halaman edit untuk memperbaruinya.
                 */
                if (
                    $existingAssessment &&
                    $existingAssessment->status === 'completed'
                ) {
                    throw ValidationException::withMessages([
                        'assessment' => 'Penilaian guru ini sudah selesai pada periode aktif. Buka penilaian yang sudah ada untuk mengeditnya.',
                    ]);
                }

                $documentScore = $this->calculateDocumentScore(
                    (int) $teacher->id,
                    (int) $supervisor->id,
                    (int) $assessmentPeriod->id
                );

                if ($existingAssessment) {
                    // Perbarui draft periode aktif yang sudah ada.
                    $assessment = $existingAssessment;

                    $assessment->update([
                        'assessment_date' => $validated['assessment_date'],
                        'pedagogik_score' => $result['averages']['Pedagogik'],
                        'kepribadian_score' => $result['averages']['Kepribadian'],
                        'sosial_score' => $result['averages']['Sosial'],
                        'profesional_score' => $result['averages']['Profesional'],
                        'document_score' => $documentScore,
                        'final_score' => $result['final_score'],
                        'status' => $status,
                    ]);

                    $assessment->details()->delete();
                } else {
                    // Buat satu penilaian baru untuk periode aktif.
                    $assessment = Assessment::create([
                        'teacher_id' => $teacher->id,
                        'supervisor_id' => $supervisor->id,
                        'assessment_period_id' => $assessmentPeriod->id,
                        'assessment_date' => $validated['assessment_date'],
                        'pedagogik_score' => $result['averages']['Pedagogik'],
                        'kepribadian_score' => $result['averages']['Kepribadian'],
                        'sosial_score' => $result['averages']['Sosial'],
                        'profesional_score' => $result['averages']['Profesional'],
                        'document_score' => $documentScore,
                        'final_score' => $result['final_score'],
                        'classification' => null,
                        'status' => $status,
                    ]);
                }

                foreach ($validated['scores'] as $indicatorId => $score) {
                    AssessmentComponentDetail::create([
                        'assessment_id' => $assessment->id,
                        'indicator_id' => $indicatorId,
                        'score' => $score,
                        'notes' => $validated['notes'][$indicatorId] ?? null,
                    ]);
                }

                // Hapus label ID3 lama agar tidak menggunakan detail lama.
                DB::table('id3_labels')
                    ->where('assessment_id', $assessment->id)
                    ->delete();

                return $assessment;
            });

            $message = $status === 'completed'
                ? "Penilaian berhasil diselesaikan. ID penilaian: {$assessment->id}."
                : "Draft penilaian berhasil disimpan. ID penilaian: {$assessment->id}.";

            return redirect()
                ->route('pengawas.assessments.index')
                ->with('success', $message);

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('GAGAL MENYIMPAN PENILAIAN', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'teacher_id' => $request->teacher_id,
                'supervisor_id' => $supervisor->id,
                'action' => $action,
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Penilaian gagal disimpan. Periksa log aplikasi.'
                );
        }
    }

    /**
     * Menampilkan detail penilaian.
     */
    public function show(Assessment $assessment): View
    {
        $supervisor = $this->getSupervisor();

        $assessment->load([
            'teacher.school',
            'supervisor',
            'details.indicator',
            'assessmentPeriod',
        ]);

        abort_if(
            !$assessment->teacher ||
            (int) $assessment->supervisor_id !== (int) $supervisor->id ||
            (int) $assessment->teacher->school_id !== (int) $supervisor->school_id,
            403,
            'Anda tidak memiliki akses ke penilaian ini.'
        );

        return view(
            'pengawas.assessments.show',
            compact('supervisor', 'assessment')
        );
    }

    /**
     * Menampilkan formulir edit penilaian berdasarkan ID.
     *
     * Pengawas hanya dapat mengedit penilaian miliknya sendiri
     * yang gurunya berada di sekolah binaannya.
     */
    public function edit(Assessment $assessment): View
    {
        $supervisor = $this->getSupervisor();

        $assessment->load([
            'teacher.school',
            'details.indicator',
            'assessmentPeriod',
        ]);

        abort_if(
            !$assessment->teacher ||
            (int) $assessment->supervisor_id !== (int) $supervisor->id ||
            (int) $assessment->teacher->school_id !== (int) $supervisor->school_id,
            403,
            'Anda tidak memiliki akses ke penilaian ini.'
        );

        $teacher = $assessment->teacher;

        $indicators = AssessmentIndicator::where('is_active', true)
            ->orderBy('competency')
            ->orderBy('code')
            ->get();

        $indicatorsByCompetency = $indicators->groupBy('competency');

        $weights = AssessmentWeight::where('is_active', true)
            ->orderBy('competency')
            ->get()
            ->keyBy('competency');

        $documentTypes = DocumentType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'pengawas.assessments.edit',
            compact(
                'supervisor',
                'teacher',
                'assessment',
                'indicators',
                'indicatorsByCompetency',
                'weights',
                'documentTypes'
            )
        );
    }

    /**
     * Memperbarui penilaian dan menghitung ulang nilai dokumen.
     *
     * Periode lama tetap dipertahankan. Untuk data lama tanpa periode,
     * periode aktif digunakan hanya sebagai fallback.
     */
    public function update(
        Request $request,
        Assessment $assessment
    ): RedirectResponse {
        $supervisor = $this->getSupervisor();

        $assessment->load('teacher');

        abort_if(
            !$assessment->teacher ||
            (int) $assessment->supervisor_id !== (int) $supervisor->id ||
            (int) $assessment->teacher->school_id !== (int) $supervisor->school_id,
            403,
            'Anda tidak memiliki akses ke penilaian ini.'
        );

        $validated = $request->validate([
            'assessment_date' => [
                'required',
                'date',
            ],
            'scores' => [
                'required',
                'array',
                'min:1',
            ],
            'scores.*' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'notes' => [
                'nullable',
                'array',
            ],
            'notes.*' => [
                'nullable',
                'string',
            ],
        ]);

        $assessmentPeriodId = $assessment->assessment_period_id;

        if (!$assessmentPeriodId) {
            $activePeriod = AssessmentPeriod::where(
                'status',
                'active'
            )->first();

            if (!$activePeriod) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Penilaian belum memiliki periode dan tidak ada periode aktif.'
                    );
            }

            $assessmentPeriodId = $activePeriod->id;
        }

        try {
            $result = $this->calculateScores($validated['scores']);

            $this->validateIndicatorScores(
                $validated['scores'],
                $result['indicators']
            );

            $documentScore = $this->calculateDocumentScore(
                (int) $assessment->teacher_id,
                (int) $supervisor->id,
                (int) $assessmentPeriodId
            );

            DB::transaction(function () use (
                $assessment,
                $validated,
                $assessmentPeriodId,
                $result,
                $documentScore
            ) {
                $assessment->update([
                    'assessment_period_id' => $assessmentPeriodId,
                    'assessment_date' => $validated['assessment_date'],
                    'pedagogik_score' => $result['averages']['Pedagogik'],
                    'kepribadian_score' => $result['averages']['Kepribadian'],
                    'sosial_score' => $result['averages']['Sosial'],
                    'profesional_score' => $result['averages']['Profesional'],
                    'document_score' => $documentScore,
                    'final_score' => $result['final_score'],
                ]);

                $assessment->details()->delete();

                foreach ($validated['scores'] as $indicatorId => $score) {
                    AssessmentComponentDetail::create([
                        'assessment_id' => $assessment->id,
                        'indicator_id' => $indicatorId,
                        'score' => $score,
                        'notes' => $validated['notes'][$indicatorId] ?? null,
                    ]);
                }

                DB::table('id3_labels')
                    ->where('assessment_id', $assessment->id)
                    ->delete();
            });

            return redirect()
                ->route('pengawas.assessments.show', $assessment)
                ->with(
                    'success',
                    'Penilaian berhasil diperbarui. Nilai dokumen dihitung berdasarkan periode penilaian.'
                );

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('GAGAL MEMPERBARUI PENILAIAN', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'assessment_id' => $assessment->id,
                'supervisor_id' => $supervisor->id,
            ]);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Penilaian gagal diperbarui. Periksa log aplikasi.'
                );
        }
    }

    /**
     * Menghapus penilaian beserta detail dan label ID3 terkait.
     */
    public function destroy(Assessment $assessment): RedirectResponse
    {
        $supervisor = $this->getSupervisor();

        $assessment->load('teacher');

        abort_if(
            !$assessment->teacher ||
            (int) $assessment->supervisor_id !== (int) $supervisor->id ||
            (int) $assessment->teacher->school_id !== (int) $supervisor->school_id,
            403,
            'Anda tidak memiliki akses ke penilaian ini.'
        );

        DB::transaction(function () use ($assessment) {
            DB::table('id3_labels')
                ->where('assessment_id', $assessment->id)
                ->delete();

            $assessment->details()->delete();
            $assessment->delete();
        });

        return redirect()
            ->route('pengawas.assessments.index')
            ->with(
                'success',
                'Penilaian berhasil dihapus.'
            );
    }
}
