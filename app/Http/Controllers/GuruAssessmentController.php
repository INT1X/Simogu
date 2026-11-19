<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentPeriod;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class GuruAssessmentController extends Controller
{
    /**
     * Menampilkan hasil penilaian guru berdasarkan periode yang dipilih.
     */
    public function index(Request $request): View
    {
        $teacher = Teacher::where('user_id', Auth::id())
            ->firstOrFail();

        $periods = AssessmentPeriod::query()
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->get();

        $activePeriod = AssessmentPeriod::where('status', 'active')
            ->orderByDesc('start_date')
            ->orderByDesc('id')
            ->first();

        $requestedPeriodId = $request->query('period');

        // Periode aktif menjadi pilihan awal.
        $selectedPeriod = null;

        if ($requestedPeriodId !== null && $requestedPeriodId !== '') {
            $selectedPeriod = $periods->firstWhere(
                'id',
                (int) $requestedPeriodId
            );

            // Abaikan ID periode yang tidak valid.
            if (!$selectedPeriod) {
                $selectedPeriod = $activePeriod;
            }
        } else {
            $selectedPeriod = $activePeriod;
        }

        $assessmentsQuery = Assessment::with([
            'supervisor',
            'details.indicator',
            'assessmentPeriod',
        ])
            ->where('teacher_id', $teacher->id);

        if ($selectedPeriod) {
            $assessmentsQuery->where(
                'assessment_period_id',
                $selectedPeriod->id
            );
        } else {
            // Jangan menampilkan gabungan seluruh periode jika
            // belum ada periode aktif dan belum ada pilihan valid.
            $assessmentsQuery->whereRaw('1 = 0');
        }

        $assessments = $assessmentsQuery
            ->orderByDesc('assessment_date')
            ->orderByDesc('id')
            ->get();

        return view(
            'guru.assessment.index',
            compact(
                'teacher',
                'assessments',
                'periods',
                'activePeriod',
                'selectedPeriod'
            )
        );
    }
}
