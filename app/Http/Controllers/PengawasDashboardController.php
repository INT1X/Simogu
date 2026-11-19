<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Supervisor;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PengawasDashboardController extends Controller
{
    /**
     * Dashboard Pengawas.
     *
     * Guru binaan diambil berdasarkan sekolah pengawas
     * yang sedang login.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Pengguna login
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        abort_if(!$user, 403, 'Pengguna belum login.');

        /*
        |--------------------------------------------------------------------------
        | Data pengawas
        |--------------------------------------------------------------------------
        */

        $supervisor = Supervisor::with('school')
            ->where('user_id', $user->id)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Guru binaan
        |--------------------------------------------------------------------------
        */

        $teachers = Teacher::with('school')
            ->where('school_id', $supervisor->school_id)
            ->latest()
            ->get();

        $totalTeachers = $teachers->count();

        $teacherIds = $teachers->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Data penilaian guru binaan
        |--------------------------------------------------------------------------
        |
        | Mengambil penilaian hanya untuk guru di sekolah pengawas.
        |
        */

        $assessments = Assessment::with('teacher')
            ->whereIn('teacher_id', $teacherIds)
            ->orderByDesc('assessment_date')
            ->orderByDesc('id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Guru yang sudah memiliki nilai akhir
        |--------------------------------------------------------------------------
        |
        | Gunakan ID guru unik agar beberapa penilaian untuk satu guru
        | tidak dihitung sebagai beberapa guru yang sudah dinilai.
        |
        */

        $completedTeacherIds = $assessments
            ->whereNotNull('final_score')
            ->pluck('teacher_id')
            ->unique();

        $completedAssessments = $completedTeacherIds->count();

        /*
        |--------------------------------------------------------------------------
        | Guru yang belum memiliki nilai akhir
        |--------------------------------------------------------------------------
        */

        $pendingAssessments = max(
            0,
            $totalTeachers - $completedAssessments
        );

        /*
        |--------------------------------------------------------------------------
        | Rata-rata nilai
        |--------------------------------------------------------------------------
        |
        | Rata-rata dihitung dari penilaian yang memiliki nilai akhir.
        | Perhitungan ini masih mencakup seluruh periode yang tersimpan.
        |
        */

        $averageScore = $assessments
            ->whereNotNull('final_score')
            ->avg('final_score');

        /*
        |--------------------------------------------------------------------------
        | Status penilaian setiap guru
        |--------------------------------------------------------------------------
        */

        foreach ($teachers as $teacher) {
            $teacher->setAttribute(
                'assessment_status',
                $completedTeacherIds->contains($teacher->id)
                    ? 'completed'
                    : 'pending'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Lima penilaian terbaru
        |--------------------------------------------------------------------------
        */

        $recentAssessments = $assessments
            ->take(5)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Kirim data ke Blade
        |--------------------------------------------------------------------------
        */

        return view('pengawas.dashboard', compact(
            'supervisor',
            'teachers',
            'totalTeachers',
            'pendingAssessments',
            'completedAssessments',
            'averageScore',
            'recentAssessments'
        ));
    }
}
