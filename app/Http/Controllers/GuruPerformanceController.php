<?php

namespace App\Http\Controllers;

use App\Models\AssessmentPeriod;
use App\Models\PerformanceAssessment;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GuruPerformanceController extends Controller
{
    /**
     * Menampilkan kinerja guru berdasarkan periode yang dipilih.
     */
    public function index(Request $request): View
    {
        $teacher = Teacher::where('user_id', Auth::id())
            ->firstOrFail();

        // Mengambil semua periode untuk pilihan riwayat.
        $periods = AssessmentPeriod::query()
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get();

        // Menentukan periode aktif sebagai pilihan awal.
        $activePeriod = AssessmentPeriod::query()
            ->where('status', 'active')
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->first();

        $requestedPeriodId = $request->query('period');

        if ($requestedPeriodId !== null && $requestedPeriodId !== '') {
            // Hanya menerima ID periode yang benar-benar tersedia.
            $selectedPeriod = $periods->firstWhere(
                'id',
                (int) $requestedPeriodId
            );

            // Jika ID tidak valid, kembali ke periode aktif.
            if (!$selectedPeriod) {
                $selectedPeriod = $activePeriod;
            }
        } else {
            $selectedPeriod = $activePeriod;
        }

        // Mengambil penilaian milik guru yang sedang login.
        $assessmentsQuery = PerformanceAssessment::with([
            'supervisor',
        ])->where('teacher_id', $teacher->id);

        if ($selectedPeriod) {
            $assessmentsQuery->where(
                'assessment_period_id',
                $selectedPeriod->id
            );
        } else {
            // Jangan gabungkan data dari periode yang berbeda.
            $assessmentsQuery->whereRaw('1 = 0');
        }

        $assessments = $assessmentsQuery
            ->orderByDesc('assessment_date')
            ->orderByDesc('id')
            ->get();

        // Statistik dihitung hanya dari periode yang dipilih.
        $latestAssessment = $assessments->first();

        $assessmentCount = $assessments->count();

        $averageScore = $assessments->avg('final_score');

        return view(
            'guru.performance.index',
            compact(
                'teacher',
                'assessments',
                'latestAssessment',
                'assessmentCount',
                'averageScore',
                'periods',
                'activePeriod',
                'selectedPeriod'
            )
        );
    }
}
