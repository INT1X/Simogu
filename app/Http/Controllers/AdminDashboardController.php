<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\Supervisor;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $totalTeachers = Teacher::count();

        $totalSchools = School::count();

        $totalSupervisors = Supervisor::count();

        // Sementara 0 karena modul penilaian belum dibuat
        $totalAssessments = 0;

        return view('admin.dashboard', compact(
            'totalTeachers',
            'totalSchools',
            'totalSupervisors',
            'totalAssessments'
        ));
    }
}