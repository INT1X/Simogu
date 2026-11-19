<?php

namespace App\Http\Controllers;

use App\Models\AssessmentDetail;
use App\Models\AssessmentPeriod;
use App\Models\PerformanceAssessment;
use App\Models\Supervisor;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PerformanceAssessmentController extends Controller
{
    /**
     * Menentukan periode berdasarkan tanggal penilaian.
     */
    private function resolveAssessmentPeriod(
        string $date
    ): AssessmentPeriod {
        $period = AssessmentPeriod::query()
            ->whereDate('start_date', '<=', $date)
            ->whereDate('end_date', '>=', $date)
            ->orderByRaw(
                "CASE WHEN status = 'active' THEN 0 ELSE 1 END"
            )
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->first();

        if (!$period) {
            throw ValidationException::withMessages([
                'assessment_date' =>
                    'Tanggal penilaian tidak termasuk dalam periode penilaian yang tersedia.',
            ]);
        }

        return $period;
    }

    /**
     * Daftar penilaian.
     */
    public function index(): View
    {
        $assessments = PerformanceAssessment::with([
            'teacher.school',
            'supervisor',
            'assessmentPeriod',
        ])
            ->latest('assessment_date')
            ->latest('id')
            ->paginate(10);

        return view(
            'admin.assessments.index',
            compact('assessments')
        );
    }

    /**
     * Form tambah penilaian.
     */
    public function create(): View
    {
        $teachers = Teacher::with('school')
            ->orderBy('name')
            ->get();

        $supervisors = Supervisor::with('school')
            ->orderBy('name')
            ->get();

        return view(
            'admin.assessments.create',
            compact('teachers', 'supervisors')
        );
    }

    /**
     * Simpan penilaian.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'teacher_id' => [
                'required',
                'exists:teachers,id',
            ],

            'supervisor_id' => [
                'required',
                'exists:supervisors,id',
            ],

            'assessment_date' => [
                'required',
                'date',
            ],

            // Pedagogik
            'ped_1' => ['required', 'integer', 'between:1,5'],
            'ped_2' => ['required', 'integer', 'between:1,5'],
            'ped_3' => ['required', 'integer', 'between:1,5'],
            'ped_4' => ['required', 'integer', 'between:1,5'],
            'ped_5' => ['required', 'integer', 'between:1,5'],
            'ped_6' => ['required', 'integer', 'between:1,5'],
            'ped_7' => ['required', 'integer', 'between:1,5'],

            // Kepribadian
            'kpb_1' => ['required', 'integer', 'between:1,5'],
            'kpb_2' => ['required', 'integer', 'between:1,5'],
            'kpb_3' => ['required', 'integer', 'between:1,5'],

            // Sosial
            'sos_1' => ['required', 'integer', 'between:1,5'],
            'sos_2' => ['required', 'integer', 'between:1,5'],

            // Profesional
            'prf_1' => ['required', 'integer', 'between:1,5'],
            'prf_2' => ['required', 'integer', 'between:1,5'],
        ]);

        // Tentukan periode berdasarkan tanggal penilaian.
        $period = $this->resolveAssessmentPeriod(
            $validated['assessment_date']
        );

        DB::transaction(function () use ($validated, $period) {
            /*
            |--------------------------------------------------------------------------
            | Hitung rata-rata kompetensi
            |--------------------------------------------------------------------------
            */

            $avgPedagogik = collect([
                $validated['ped_1'],
                $validated['ped_2'],
                $validated['ped_3'],
                $validated['ped_4'],
                $validated['ped_5'],
                $validated['ped_6'],
                $validated['ped_7'],
            ])->avg();

            $avgKepribadian = collect([
                $validated['kpb_1'],
                $validated['kpb_2'],
                $validated['kpb_3'],
            ])->avg();

            $avgSosial = collect([
                $validated['sos_1'],
                $validated['sos_2'],
            ])->avg();

            $avgProfesional = collect([
                $validated['prf_1'],
                $validated['prf_2'],
            ])->avg();

            /*
            |--------------------------------------------------------------------------
            | Hitung nilai akhir
            |--------------------------------------------------------------------------
            */

            $finalScore = collect([
                $avgPedagogik,
                $avgKepribadian,
                $avgSosial,
                $avgProfesional,
            ])->avg();

            /*
            |--------------------------------------------------------------------------
            | Tentukan klasifikasi
            |--------------------------------------------------------------------------
            */

            $classification = match (true) {
                $finalScore >= 4.50 => 'Sangat Baik',
                $finalScore >= 3.50 => 'Baik',
                $finalScore >= 2.50 => 'Cukup',
                default => 'Kurang',
            };

            /*
            |--------------------------------------------------------------------------
            | Simpan penilaian utama
            |--------------------------------------------------------------------------
            */

            $assessment = PerformanceAssessment::create([
                'teacher_id' => $validated['teacher_id'],
                'supervisor_id' => $validated['supervisor_id'],
                'assessment_period_id' => $period->id,
                'assessment_date' => $validated['assessment_date'],

                'avg_pedagogik' => $avgPedagogik,
                'avg_kepribadian' => $avgKepribadian,
                'avg_sosial' => $avgSosial,
                'avg_profesional' => $avgProfesional,

                'final_score' => $finalScore,
                'final_classification' => $classification,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Simpan detail indikator
            |--------------------------------------------------------------------------
            */

            AssessmentDetail::create([
                'performance_assessment_id' => $assessment->id,

                'ped_1' => $validated['ped_1'],
                'ped_2' => $validated['ped_2'],
                'ped_3' => $validated['ped_3'],
                'ped_4' => $validated['ped_4'],
                'ped_5' => $validated['ped_5'],
                'ped_6' => $validated['ped_6'],
                'ped_7' => $validated['ped_7'],

                'kpb_1' => $validated['kpb_1'],
                'kpb_2' => $validated['kpb_2'],
                'kpb_3' => $validated['kpb_3'],

                'sos_1' => $validated['sos_1'],
                'sos_2' => $validated['sos_2'],

                'prf_1' => $validated['prf_1'],
                'prf_2' => $validated['prf_2'],

                'avg_pedagogik' => $avgPedagogik,
                'avg_kepribadian' => $avgKepribadian,
                'avg_sosial' => $avgSosial,
                'avg_profesional' => $avgProfesional,
            ]);
        });

        return redirect()
            ->route('admin.assessments.index')
            ->with(
                'success',
                'Penilaian kinerja berhasil disimpan.'
            );
    }

    /**
     * Detail penilaian.
     */
    public function show(
        PerformanceAssessment $assessment
    ): View {
        $assessment->load([
            'teacher.school',
            'supervisor.school',
            'detail',
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
        PerformanceAssessment $assessment
    ): View {
        $assessment->load([
            'detail',
            'assessmentPeriod',
        ]);

        $teachers = Teacher::with('school')
            ->orderBy('name')
            ->get();

        $supervisors = Supervisor::with('school')
            ->orderBy('name')
            ->get();

        return view(
            'admin.assessments.edit',
            compact(
                'assessment',
                'teachers',
                'supervisors'
            )
        );
    }

    /**
     * Perbarui penilaian.
     */
    public function update(
        Request $request,
        PerformanceAssessment $assessment
    ): RedirectResponse {
        $validated = $request->validate([
            'teacher_id' => [
                'required',
                'exists:teachers,id',
            ],

            'supervisor_id' => [
                'required',
                'exists:supervisors,id',
            ],

            'assessment_date' => [
                'required',
                'date',
            ],

            // Pedagogik
            'ped_1' => ['required', 'integer', 'between:1,5'],
            'ped_2' => ['required', 'integer', 'between:1,5'],
            'ped_3' => ['required', 'integer', 'between:1,5'],
            'ped_4' => ['required', 'integer', 'between:1,5'],
            'ped_5' => ['required', 'integer', 'between:1,5'],
            'ped_6' => ['required', 'integer', 'between:1,5'],
            'ped_7' => ['required', 'integer', 'between:1,5'],

            // Kepribadian
            'kpb_1' => ['required', 'integer', 'between:1,5'],
            'kpb_2' => ['required', 'integer', 'between:1,5'],
            'kpb_3' => ['required', 'integer', 'between:1,5'],

            // Sosial
            'sos_1' => ['required', 'integer', 'between:1,5'],
            'sos_2' => ['required', 'integer', 'between:1,5'],

            // Profesional
            'prf_1' => ['required', 'integer', 'between:1,5'],
            'prf_2' => ['required', 'integer', 'between:1,5'],
        ]);

        // Periode mengikuti tanggal penilaian yang diperbarui.
        $period = $this->resolveAssessmentPeriod(
            $validated['assessment_date']
        );

        DB::transaction(function () use (
            $validated,
            $assessment,
            $period
        ) {
            /*
            |--------------------------------------------------------------------------
            | Hitung ulang rata-rata kompetensi
            |--------------------------------------------------------------------------
            */

            $avgPedagogik = collect([
                $validated['ped_1'],
                $validated['ped_2'],
                $validated['ped_3'],
                $validated['ped_4'],
                $validated['ped_5'],
                $validated['ped_6'],
                $validated['ped_7'],
            ])->avg();

            $avgKepribadian = collect([
                $validated['kpb_1'],
                $validated['kpb_2'],
                $validated['kpb_3'],
            ])->avg();

            $avgSosial = collect([
                $validated['sos_1'],
                $validated['sos_2'],
            ])->avg();

            $avgProfesional = collect([
                $validated['prf_1'],
                $validated['prf_2'],
            ])->avg();

            /*
            |--------------------------------------------------------------------------
            | Hitung ulang nilai akhir dan klasifikasi
            |--------------------------------------------------------------------------
            */

            $finalScore = collect([
                $avgPedagogik,
                $avgKepribadian,
                $avgSosial,
                $avgProfesional,
            ])->avg();

            $classification = match (true) {
                $finalScore >= 4.50 => 'Sangat Baik',
                $finalScore >= 3.50 => 'Baik',
                $finalScore >= 2.50 => 'Cukup',
                default => 'Kurang',
            };

            /*
            |--------------------------------------------------------------------------
            | Perbarui penilaian utama
            |--------------------------------------------------------------------------
            */

            $assessment->update([
                'teacher_id' => $validated['teacher_id'],
                'supervisor_id' => $validated['supervisor_id'],
                'assessment_period_id' => $period->id,
                'assessment_date' => $validated['assessment_date'],

                'avg_pedagogik' => $avgPedagogik,
                'avg_kepribadian' => $avgKepribadian,
                'avg_sosial' => $avgSosial,
                'avg_profesional' => $avgProfesional,

                'final_score' => $finalScore,
                'final_classification' => $classification,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Perbarui atau buat detail indikator
            |--------------------------------------------------------------------------
            */

            $assessment->detail()->updateOrCreate(
                [
                    'performance_assessment_id' => $assessment->id,
                ],
                [
                    'ped_1' => $validated['ped_1'],
                    'ped_2' => $validated['ped_2'],
                    'ped_3' => $validated['ped_3'],
                    'ped_4' => $validated['ped_4'],
                    'ped_5' => $validated['ped_5'],
                    'ped_6' => $validated['ped_6'],
                    'ped_7' => $validated['ped_7'],

                    'kpb_1' => $validated['kpb_1'],
                    'kpb_2' => $validated['kpb_2'],
                    'kpb_3' => $validated['kpb_3'],

                    'sos_1' => $validated['sos_1'],
                    'sos_2' => $validated['sos_2'],

                    'prf_1' => $validated['prf_1'],
                    'prf_2' => $validated['prf_2'],

                    'avg_pedagogik' => $avgPedagogik,
                    'avg_kepribadian' => $avgKepribadian,
                    'avg_sosial' => $avgSosial,
                    'avg_profesional' => $avgProfesional,
                ]
            );
        });

        return redirect()
            ->route('admin.assessments.index')
            ->with(
                'success',
                'Penilaian kinerja berhasil diperbarui.'
            );
    }

    /**
     * Hapus penilaian.
     */
    public function destroy(
        PerformanceAssessment $assessment
    ): RedirectResponse {
        DB::transaction(function () use ($assessment) {
            // Hapus detail terlebih dahulu jika tidak memakai cascade.
            $assessment->detail()->delete();

            $assessment->delete();
        });

        return redirect()
            ->route('admin.assessments.index')
            ->with(
                'success',
                'Penilaian kinerja berhasil dihapus.'
            );
    }
}
