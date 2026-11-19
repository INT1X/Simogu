<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Supervisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PengawasReportController extends Controller
{
    /**
     * Laporan penilaian guru binaan pengawas.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | PENGAWAS LOGIN
        |--------------------------------------------------------------------------
        */

        $supervisor = Supervisor::with('school')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | QUERY DASAR
        |--------------------------------------------------------------------------
        |
        | Pengawas hanya boleh melihat assessment:
        | - milik dirinya
        | - guru dari sekolah binaannya
        |
        */

        $baseQuery = Assessment::query()
            ->where('supervisor_id', $supervisor->id)
            ->whereHas('teacher', function ($query) use ($supervisor) {
                $query->where(
                    'school_id',
                    $supervisor->school_id
                );
            });

        /*
        |--------------------------------------------------------------------------
        | FILTER GURU
        |--------------------------------------------------------------------------
        */

        if ($request->filled('teacher_id')) {
            $baseQuery->where(
                'teacher_id',
                $request->teacher_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $baseQuery->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KLASIFIKASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('classification')) {
            $baseQuery->where(
                'classification',
                $request->classification
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL MULAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {
            $baseQuery->whereDate(
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
            $baseQuery->whereDate(
                'assessment_date',
                '<=',
                $request->date_to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA LAPORAN
        |--------------------------------------------------------------------------
        */

        $assessments = (clone $baseQuery)
            ->with([
                'teacher.school',
                'supervisor',
            ])
            ->orderByDesc('assessment_date')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | DAFTAR GURU BINAAN
        |--------------------------------------------------------------------------
        */

        $teachers = \App\Models\Teacher::query()
            ->where(
                'school_id',
                $supervisor->school_id
            )
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalAssessments = (clone $baseQuery)
            ->count();

        $veryGood = (clone $baseQuery)
            ->where('classification', 'Sangat Baik')
            ->count();

        $good = (clone $baseQuery)
            ->where('classification', 'Baik')
            ->count();

        $fair = (clone $baseQuery)
            ->where('classification', 'Cukup')
            ->count();

        $poor = (clone $baseQuery)
            ->where('classification', 'Kurang')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RATA-RATA NILAI
        |--------------------------------------------------------------------------
        */

        $averageScore = (clone $baseQuery)
            ->whereNotNull('final_score')
            ->avg('final_score');

        /*
        |--------------------------------------------------------------------------
        | JUMLAH GURU
        |--------------------------------------------------------------------------
        */

        $totalTeachers = \App\Models\Teacher::query()
            ->where(
                'school_id',
                $supervisor->school_id
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | GURU SUDAH DINILAI
        |--------------------------------------------------------------------------
        */

        $assessedTeachers = (clone $baseQuery)
            ->distinct('teacher_id')
            ->count('teacher_id');

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pengawas.reports.index',
            compact(
                'supervisor',
                'teachers',
                'assessments',
                'totalAssessments',
                'veryGood',
                'good',
                'fair',
                'poor',
                'averageScore',
                'totalTeachers',
                'assessedTeachers'
            )
        );
    }
}