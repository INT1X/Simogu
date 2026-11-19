<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\School;
use App\Models\Supervisor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Menampilkan laporan penilaian guru.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA FILTER
        |--------------------------------------------------------------------------
        */

        $schools = School::orderBy('name')->get();

        $supervisors = Supervisor::orderBy('name')->get();


        /*
        |--------------------------------------------------------------------------
        | QUERY ASSESSMENT
        |--------------------------------------------------------------------------
        */

        $query = Assessment::with([
            'teacher.school',
            'supervisor.school',
        ]);


        /*
        |--------------------------------------------------------------------------
        | FILTER SEKOLAH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('school_id')) {

            $query->whereHas('teacher', function ($teacherQuery) use ($request) {

                $teacherQuery->where('school_id', $request->school_id);

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER PENGAWAS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('supervisor_id')) {

            $query->where(
                'supervisor_id',
                $request->supervisor_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'assessment_date',
                '>=',
                $request->date_from
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL SELESAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_to')) {

            $query->whereDate(
                'assessment_date',
                '<=',
                $request->date_to
            );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA
        |--------------------------------------------------------------------------
        */

        $assessments = $query
            ->orderByDesc('assessment_date')
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        |
        | Statistik mengikuti filter yang sedang digunakan.
        |
        */

        $statisticsQuery = Assessment::query();


        /*
        | Filter sekolah
        */

        if ($request->filled('school_id')) {

            $statisticsQuery->whereHas('teacher', function ($teacherQuery) use ($request) {

                $teacherQuery->where(
                    'school_id',
                    $request->school_id
                );

            });
        }


        /*
        | Filter pengawas
        */

        if ($request->filled('supervisor_id')) {

            $statisticsQuery->where(
                'supervisor_id',
                $request->supervisor_id
            );
        }


        /*
        | Filter status
        */

        if ($request->filled('status')) {

            $statisticsQuery->where(
                'status',
                $request->status
            );
        }


        /*
        | Filter tanggal
        */

        if ($request->filled('date_from')) {

            $statisticsQuery->whereDate(
                'assessment_date',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {

            $statisticsQuery->whereDate(
                'assessment_date',
                '<=',
                $request->date_to
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalAssessments = (clone $statisticsQuery)->count();


        /*
        |--------------------------------------------------------------------------
        | KLASIFIKASI
        |--------------------------------------------------------------------------
        */

        $veryGood = (clone $statisticsQuery)
            ->where('classification', 'Sangat Baik')
            ->count();

        $good = (clone $statisticsQuery)
            ->where('classification', 'Baik')
            ->count();

        $fair = (clone $statisticsQuery)
            ->where('classification', 'Cukup')
            ->count();

        $poor = (clone $statisticsQuery)
            ->where('classification', 'Kurang')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA NILAI
        |--------------------------------------------------------------------------
        */

        $averageScore = (clone $statisticsQuery)
            ->whereNotNull('final_score')
            ->avg('final_score');


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.reports.index', compact(
            'assessments',
            'schools',
            'supervisors',
            'totalAssessments',
            'veryGood',
            'good',
            'fair',
            'poor',
            'averageScore'
        ));
    }
}