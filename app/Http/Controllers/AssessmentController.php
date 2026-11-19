<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentDetail;
use App\Models\AssessmentIndicator;
use App\Models\AssessmentPeriod;
use App\Models\AssessmentWeight;
use App\Models\Teacher;
use App\Models\Supervisor;
use App\Models\TeacherDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    /**
     * Menampilkan daftar penilaian.
     *
     * Pengawas hanya melihat penilaian yang dibuat olehnya.
     * Admin dapat melihat seluruh penilaian.
     */
    public function index(): View
    {
        $user = Auth::user();

        $query = Assessment::with([
            'teacher',
            'supervisor',
            'assessmentPeriod',
        ])->latest('assessment_date');

        if ($user->role === 'pengawas') {
            $supervisor = Supervisor::where(
                'user_id',
                $user->id
            )->first();

            if (!$supervisor) {
                abort(403, 'Data pengawas tidak ditemukan.');
            }

            $query->where(
                'supervisor_id',
                $supervisor->id
            );
        }

        $assessments = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.assessments.index',
            compact('assessments')
        );
    }

    /**
     * Form membuat penilaian.
     */
    public function create(): View
    {
        $user = Auth::user();

        $teachers = Teacher::with('school')
            ->orderBy('name')
            ->get();

        $indicators = AssessmentIndicator::where(
            'is_active',
            true
        )
            ->orderBy('competency')
            ->orderBy('code')
            ->get();

        $weights = AssessmentWeight::where(
            'is_active',
            true
        )
            ->orderBy('competency')
            ->get();

        $supervisor = null;

        if ($user->role === 'pengawas') {
            $supervisor = Supervisor::where(
                'user_id',
                $user->id
            )->first();

            if (!$supervisor) {
                abort(
                    403,
                    'Data pengawas tidak ditemukan.'
                );
            }
        }

        $assessmentPeriod = AssessmentPeriod::where(
            'status',
            'active'
        )->first();

        return view(
            'admin.assessments.create',
            compact(
                'teachers',
                'indicators',
                'weights',
                'supervisor',
                'assessmentPeriod'
            )
        );
    }

    /**
     * Menyimpan penilaian baru.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        $user = Auth::user();

        $validated = $request->validate([
            'teacher_id' => [
                'required',
                'exists:teachers,id',
            ],

            'assessment_date' => [
                'required',
                'date',
            ],

            'status' => [
                'nullable',
                'in:draft,selesai',
            ],

            'scores' => [
                'required',
                'array',
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
                'max:1000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Cari supervisor
        |--------------------------------------------------------------------------
        */

        $supervisor = Supervisor::where(
            'user_id',
            $user->id
        )->first();

        if (!$supervisor) {
            abort(
                403,
                'Data pengawas tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Ambil periode penilaian aktif
        |--------------------------------------------------------------------------
        */

        $assessmentPeriod = AssessmentPeriod::where(
            'status',
            'active'
        )->first();

        if (!$assessmentPeriod) {
            return back()
                ->withInput()
                ->withErrors([
                    'assessment_period' =>
                        'Tidak ada periode penilaian yang aktif.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Pastikan guru valid
        |--------------------------------------------------------------------------
        */

        Teacher::findOrFail(
            $validated['teacher_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil indikator aktif
        |--------------------------------------------------------------------------
        */

        $indicators = AssessmentIndicator::where(
            'is_active',
            true
        )
            ->get()
            ->keyBy('id');

        /*
        |--------------------------------------------------------------------------
        | Ambil bobot kompetensi
        |--------------------------------------------------------------------------
        */

        $weights = AssessmentWeight::where(
            'is_active',
            true
        )
            ->get()
            ->keyBy('competency');

        $totalWeight = $weights->sum(
            fn ($weight) => (float) $weight->weight
        );

        if ($totalWeight <= 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'scores' =>
                        'Bobot penilaian belum dikonfigurasi.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung nilai kompetensi
        |--------------------------------------------------------------------------
        */

        $competencyScores = [
            'Pedagogik' => [],
            'Kepribadian' => [],
            'Sosial' => [],
            'Profesional' => [],
        ];

        foreach ($validated['scores'] as $indicatorId => $score) {
            if (!$indicators->has($indicatorId)) {
                continue;
            }

            $indicator = $indicators->get($indicatorId);
            $competency = $indicator->competency;

            if (array_key_exists($competency, $competencyScores)) {
                $competencyScores[$competency][] = (float) $score;
            }
        }

        $pedagogikScore = $this->average(
            $competencyScores['Pedagogik']
        );

        $kepribadianScore = $this->average(
            $competencyScores['Kepribadian']
        );

        $sosialScore = $this->average(
            $competencyScores['Sosial']
        );

        $profesionalScore = $this->average(
            $competencyScores['Profesional']
        );

        /*
        |--------------------------------------------------------------------------
        | Hitung nilai akhir kompetensi
        |--------------------------------------------------------------------------
        */

        $scoreMap = [
            'Pedagogik' => $pedagogikScore,
            'Kepribadian' => $kepribadianScore,
            'Sosial' => $sosialScore,
            'Profesional' => $profesionalScore,
        ];

        $finalScore = 0;

        foreach ($scoreMap as $competency => $score) {
            if (!$weights->has($competency)) {
                continue;
            }

            $weight = (float) $weights
                ->get($competency)
                ->weight;

            $finalScore += ($score * $weight) / $totalWeight;
        }

        /*
        |--------------------------------------------------------------------------
        | Hitung nilai dokumen sesuai periode
        |--------------------------------------------------------------------------
        */

        $documentScore = $this->calculateDocumentScore(
            (int) $validated['teacher_id'],
            (int) $supervisor->id,
            (int) $assessmentPeriod->id
        );

        $status = $validated['status'] ?? 'selesai';

        $classification = $this->classify(
            $finalScore
        );

        /*
        |--------------------------------------------------------------------------
        | Simpan assessment dan detail dalam transaksi
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $validated,
            $supervisor,
            $assessmentPeriod,
            $pedagogikScore,
            $kepribadianScore,
            $sosialScore,
            $profesionalScore,
            $documentScore,
            $finalScore,
            $classification,
            $status,
            $indicators
        ) {
            $assessment = Assessment::create([
                'teacher_id' =>
                    $validated['teacher_id'],

                'supervisor_id' =>
                    $supervisor->id,

                'assessment_period_id' =>
                    $assessmentPeriod->id,

                'assessment_date' =>
                    $validated['assessment_date'],

                'pedagogik_score' =>
                    $pedagogikScore,

                'kepribadian_score' =>
                    $kepribadianScore,

                'sosial_score' =>
                    $sosialScore,

                'profesional_score' =>
                    $profesionalScore,

                'document_score' =>
                    $documentScore,

                'final_score' =>
                    $finalScore,

                'classification' =>
                    $classification,

                'status' =>
                    $status,
            ]);

            foreach ($validated['scores'] as $indicatorId => $score) {
                if (!$indicators->has($indicatorId)) {
                    continue;
                }

                AssessmentDetail::create([
                    'assessment_id' =>
                        $assessment->id,

                    'indicator_id' =>
                        $indicatorId,

                    'score' =>
                        $score,

                    'notes' =>
                        $validated['notes'][$indicatorId] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('pengawas.assessments.index')
            ->with(
                'success',
                'Penilaian guru berhasil disimpan.'
            );
    }

    /**
     * Menampilkan detail penilaian.
     */
    public function show(
        Assessment $assessment
    ): View {
        $this->authorizeAssessment($assessment);

        $assessment->load([
            'teacher',
            'supervisor',
            'details.indicator',
            'assessmentPeriod',
        ]);

        return view(
            'admin.assessments.show',
            compact('assessment')
        );
    }

    /**
     * Form edit penilaian.
     */
    public function edit(
        Assessment $assessment
    ): View {
        $this->authorizeAssessment($assessment);

        if ($assessment->status === 'selesai') {
            abort(
                403,
                'Penilaian yang sudah selesai tidak dapat diedit.'
            );
        }

        $teachers = Teacher::with('school')
            ->orderBy('name')
            ->get();

        $indicators = AssessmentIndicator::where(
            'is_active',
            true
        )
            ->orderBy('competency')
            ->orderBy('code')
            ->get();

        $weights = AssessmentWeight::where(
            'is_active',
            true
        )
            ->orderBy('competency')
            ->get();

        $assessment->load([
            'details.indicator',
            'teacher',
            'supervisor',
            'assessmentPeriod',
        ]);

        return view(
            'admin.assessments.edit',
            compact(
                'assessment',
                'teachers',
                'indicators',
                'weights'
            )
        );
    }

    /**
     * Memperbarui penilaian.
     */
    public function update(
        Request $request,
        Assessment $assessment
    ): RedirectResponse {
        $this->authorizeAssessment($assessment);

        if ($assessment->status === 'selesai') {
            abort(
                403,
                'Penilaian yang sudah selesai tidak dapat diubah.'
            );
        }

        $validated = $request->validate([
            'teacher_id' => [
                'required',
                'exists:teachers,id',
            ],

            'assessment_date' => [
                'required',
                'date',
            ],

            'status' => [
                'required',
                'in:draft,selesai',
            ],

            'scores' => [
                'required',
                'array',
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
                'max:1000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pertahankan periode milik assessment
        |--------------------------------------------------------------------------
        */

        $assessmentPeriodId = $assessment->assessment_period_id;

        if (!$assessmentPeriodId) {
            $assessmentPeriod = AssessmentPeriod::where(
                'status',
                'active'
            )->first();

            if (!$assessmentPeriod) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'assessment_period' =>
                            'Penilaian ini belum memiliki periode dan tidak ada periode aktif.',
                    ]);
            }

            $assessmentPeriodId = $assessmentPeriod->id;
        }

        $indicators = AssessmentIndicator::where(
            'is_active',
            true
        )
            ->get()
            ->keyBy('id');

        $weights = AssessmentWeight::where(
            'is_active',
            true
        )
            ->get()
            ->keyBy('competency');

        $competencyScores = [
            'Pedagogik' => [],
            'Kepribadian' => [],
            'Sosial' => [],
            'Profesional' => [],
        ];

        foreach ($validated['scores'] as $indicatorId => $score) {
            if (!$indicators->has($indicatorId)) {
                continue;
            }

            $indicator = $indicators->get($indicatorId);
            $competency = $indicator->competency;

            if (array_key_exists($competency, $competencyScores)) {
                $competencyScores[$competency][] = (float) $score;
            }
        }

        $pedagogikScore = $this->average(
            $competencyScores['Pedagogik']
        );

        $kepribadianScore = $this->average(
            $competencyScores['Kepribadian']
        );

        $sosialScore = $this->average(
            $competencyScores['Sosial']
        );

        $profesionalScore = $this->average(
            $competencyScores['Profesional']
        );

        $totalWeight = $weights->sum(
            fn ($weight) => (float) $weight->weight
        );

        if ($totalWeight <= 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'scores' =>
                        'Bobot penilaian belum dikonfigurasi.',
                ]);
        }

        $scoreMap = [
            'Pedagogik' => $pedagogikScore,
            'Kepribadian' => $kepribadianScore,
            'Sosial' => $sosialScore,
            'Profesional' => $profesionalScore,
        ];

        $finalScore = 0;

        foreach ($scoreMap as $competency => $score) {
            if (!$weights->has($competency)) {
                continue;
            }

            $weight = (float) $weights
                ->get($competency)
                ->weight;

            $finalScore += ($score * $weight) / $totalWeight;
        }

        $documentScore = $this->calculateDocumentScore(
            (int) $validated['teacher_id'],
            (int) $assessment->supervisor_id,
            (int) $assessmentPeriodId
        );

        $classification = $this->classify(
            $finalScore
        );

        DB::transaction(function () use (
            $assessment,
            $validated,
            $assessmentPeriodId,
            $pedagogikScore,
            $kepribadianScore,
            $sosialScore,
            $profesionalScore,
            $documentScore,
            $finalScore,
            $classification,
            $indicators
        ) {
            $assessment->update([
                'teacher_id' =>
                    $validated['teacher_id'],

                'assessment_period_id' =>
                    $assessmentPeriodId,

                'assessment_date' =>
                    $validated['assessment_date'],

                'pedagogik_score' =>
                    $pedagogikScore,

                'kepribadian_score' =>
                    $kepribadianScore,

                'sosial_score' =>
                    $sosialScore,

                'profesional_score' =>
                    $profesionalScore,

                'document_score' =>
                    $documentScore,

                'final_score' =>
                    $finalScore,

                'classification' =>
                    $classification,

                'status' =>
                    $validated['status'],
            ]);

            AssessmentDetail::where(
                'assessment_id',
                $assessment->id
            )->delete();

            foreach ($validated['scores'] as $indicatorId => $score) {
                if (!$indicators->has($indicatorId)) {
                    continue;
                }

                AssessmentDetail::create([
                    'assessment_id' =>
                        $assessment->id,

                    'indicator_id' =>
                        $indicatorId,

                    'score' =>
                        $score,

                    'notes' =>
                        $validated['notes'][$indicatorId] ?? null,
                ]);
            }
        });

        return redirect()
            ->route(
                'pengawas.assessments.show',
                $assessment
            )
            ->with(
                'success',
                'Penilaian berhasil diperbarui.'
            );
    }

    /**
     * Menghapus penilaian.
     */
    public function destroy(
        Assessment $assessment
    ): RedirectResponse {
        $this->authorizeAssessment($assessment);

        if ($assessment->status === 'selesai') {
            abort(
                403,
                'Penilaian yang sudah selesai tidak dapat dihapus.'
            );
        }

        DB::transaction(function () use ($assessment) {
            AssessmentDetail::where(
                'assessment_id',
                $assessment->id
            )->delete();

            $assessment->delete();
        });

        return redirect()
            ->route('pengawas.assessments.index')
            ->with(
                'success',
                'Penilaian berhasil dihapus.'
            );
    }

    /**
     * Menghitung rata-rata nilai.
     */
    private function average(
        array $scores
    ): float {
        if (count($scores) === 0) {
            return 0;
        }

        return round(
            array_sum($scores) / count($scores),
            2
        );
    }

    /**
     * Menghitung nilai dokumen berdasarkan periode penilaian.
     */
    private function calculateDocumentScore(
        int $teacherId,
        int $supervisorId,
        int $assessmentPeriodId
    ): float {
        $documents = TeacherDocument::with('documentType')
            ->where('teacher_id', $teacherId)
            ->where('assessment_period_id', $assessmentPeriodId)
            ->get();

        $totalPercentage = 0;
        $totalDocuments = 0;

        foreach ($documents as $document) {
            $verification = $document->verifications()
                ->where('supervisor_id', $supervisorId)
                ->where('status', 'verified')
                ->whereNotNull('score')
                ->latest('verified_at')
                ->first();

            if (!$verification || !$document->documentType) {
                continue;
            }

            $maxScore = (float) $document->documentType->max_score;
            $score = (float) $verification->score;

            if ($maxScore <= 0) {
                continue;
            }

            $totalPercentage += ($score / $maxScore) * 100;
            $totalDocuments++;
        }

        if ($totalDocuments === 0) {
            return 0;
        }

        return round(
            $totalPercentage / $totalDocuments,
            2
        );
    }

    /**
     * Klasifikasi berbasis threshold.
     */
    private function classify(
        float $score
    ): string {
        if ($score >= 90) {
            return 'Sangat Baik';
        }

        if ($score >= 80) {
            return 'Baik';
        }

        if ($score >= 70) {
            return 'Cukup';
        }

        return 'Perlu Pembinaan';
    }

    /**
     * Memastikan assessment boleh diakses oleh user.
     */
    private function authorizeAssessment(
        Assessment $assessment
    ): void {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return;
        }

        if ($user->role === 'pengawas') {
            $supervisor = Supervisor::where(
                'user_id',
                $user->id
            )->first();

            if (
                !$supervisor ||
                (int) $assessment->supervisor_id !== (int) $supervisor->id
            ) {
                abort(
                    403,
                    'Anda tidak memiliki akses ke penilaian ini.'
                );
            }

            return;
        }

        abort(
            403,
            'Anda tidak memiliki akses ke penilaian.'
        );
    }
}
