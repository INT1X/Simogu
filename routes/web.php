<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuruProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\PerformanceAssessmentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\AssessmentIndicatorController;
use App\Http\Controllers\AssessmentWeightController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PengawasDashboardController;
use App\Http\Controllers\PengawasTeacherController;
use App\Http\Controllers\PengawasAssessmentController;
use App\Http\Controllers\PengawasReportController;
use App\Http\Controllers\PengawasDocumentController;
use App\Http\Controllers\AdminId3Controller;
use App\Http\Controllers\AssessmentPeriodController;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| SEMUA USER YANG SUDAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD REDIRECT BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {

        $user = Auth::user();

        return match ($user->role) {

            'admin' =>
                redirect()->route('admin.dashboard'),

            'pengawas' =>
                redirect()->route('pengawas.dashboard'),

            'guru' =>
                redirect()->route('guru.dashboard'),

            default =>
                abort(
                    403,
                    'Role pengguna tidak valid.'
                ),
        };
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD ADMIN
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', [
                AdminDashboardController::class,
                'index'
            ])->name('dashboard');


            // =================================================
            // PERIODE PENILAIAN SEMESTER
            // =================================================
    
            Route::resource(
                'assessment-periods',
                AssessmentPeriodController::class
            )->except(['show']);

            /*
            |--------------------------------------------------------------------------
            | DATA SEKOLAH
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'schools',
                SchoolController::class
            );


            /*
            |--------------------------------------------------------------------------
            | DATA GURU
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'teachers',
                TeacherController::class
            );


            /*
            |--------------------------------------------------------------------------
            | DATA PENGAWAS
            |--------------------------------------------------------------------------
            */

            Route::resource(
                'supervisors',
                SupervisorController::class
            );


            /*
            |--------------------------------------------------------------------------
            | PENILAIAN KINERJA LAMA
            |--------------------------------------------------------------------------
            |
            | Modul lama tetap dipertahankan agar sistem sebelumnya
            | tidak langsung rusak.
            |
            */

            Route::resource(
                'performance-assessments',
                PerformanceAssessmentController::class
            );


            /*
            |--------------------------------------------------------------------------
            | ASSESSMENTS
            |--------------------------------------------------------------------------
            |
            | Modul assessment.
            |
            */

            Route::resource(
                'assessments',
                AssessmentController::class
            );


            /*
            |--------------------------------------------------------------------------
            | INDIKATOR PENILAIAN
            |--------------------------------------------------------------------------
            |
            | Admin mengatur:
            |
            | - Kode indikator
            | - Kompetensi
            | - Nama indikator
            | - Deskripsi
            | - Bobot indikator
            | - Status aktif
            |
            */

            Route::resource(
                'assessment-indicators',
                AssessmentIndicatorController::class
            );


            /*
            |--------------------------------------------------------------------------
            | BOBOT PENILAIAN
            |--------------------------------------------------------------------------
            |
            | Admin mengatur bobot:
            |
            | - Pedagogik
            | - Kepribadian
            | - Sosial
            | - Profesional
            |
            */

            Route::resource(
                'assessment-weights',
                AssessmentWeightController::class
            );


            /*
            |--------------------------------------------------------------------------
            | JENIS DOKUMEN
            |--------------------------------------------------------------------------
            |
            | Admin mengatur jenis dokumen yang dapat diupload guru.
            |
            */

            Route::resource(
                'document-types',
                DocumentTypeController::class
            )->except([
                        'show'
                    ]);


            /*
            |--------------------------------------------------------------------------
            | LAPORAN
            |--------------------------------------------------------------------------
            |
            | Admin dapat melihat laporan penilaian.
            |
            | URL:
            | /admin/reports
            |
            | Route name:
            | admin.reports.index
            |
            */

            Route::get('/reports', [
                ReportController::class,
                'index'
            ])->name('reports.index');


            Route::get('/id3', [
                AdminId3Controller::class,
                'index'
            ])->name('id3.index');

            Route::post('/id3/train', [
                AdminId3Controller::class,
                'train'
            ])->name('id3.train');

            Route::post('/id3/evaluate', [
                AdminId3Controller::class,
                'evaluate'
            ])->name('id3.evaluate');

            Route::post('/id3/label', [
                AdminId3Controller::class,
                'saveLabel'
            ])->name('id3.label');

            Route::post('/id3/thresholds', [
                AdminId3Controller::class,
                'saveThresholds'
            ])->name('id3.thresholds');

            Route::post('/id3/sync-labels', [
                AdminId3Controller::class,
                'syncLabels'
            ])->name('id3.sync-labels');

        });


    /*
|--------------------------------------------------------------------------
| PENGAWAS
|--------------------------------------------------------------------------
*/

    Route::middleware('role:pengawas')
        ->prefix('pengawas')
        ->name('pengawas.')
        ->group(function () {

            /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

            Route::get('/dashboard', [
                PengawasDashboardController::class,
                'index'
            ])->name('dashboard');


            /*
        |--------------------------------------------------------------------------
        | GURU BINAAN
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'teachers',
                PengawasTeacherController::class
            )->only([
                        'index',
                        'show'
                    ]);



            /*
        |--------------------------------------------------------------------------
        | VERIFIKASI DOKUMEN GURU
        |--------------------------------------------------------------------------
        */

            Route::get('/documents', [
                PengawasDocumentController::class,
                'index'
            ])->name('documents.index');

            Route::get('/documents/{teacherDocument}', [
                PengawasDocumentController::class,
                'show'
            ])->name('documents.show');

            Route::put('/documents/{teacherDocument}/verify', [
                PengawasDocumentController::class,
                'verify'
            ])->name('documents.verify');

            Route::put('/documents/{teacherDocument}/reject', [
                PengawasDocumentController::class,
                'reject'
            ])->name('documents.reject');

            Route::get(
                '/documents/{teacherDocument}/download',
                [PengawasDocumentController::class, 'download']
            )->name('documents.download');


            /*
        |--------------------------------------------------------------------------
        | PENILAIAN
        |--------------------------------------------------------------------------
        */

            Route::resource(
                'assessments',
                PengawasAssessmentController::class
            );


            /*
        |--------------------------------------------------------------------------
        | RIWAYAT PENILAIAN
        |--------------------------------------------------------------------------
        */

            Route::get('/assessments-history', [
                AssessmentController::class,
                'history'
            ])->name('assessments.history');


            /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */

            Route::get('/reports', [
                PengawasReportController::class,
                'index'
            ])->name('reports.index');

            /*
|--------------------------------------------------------------------------
| PROFILE PENGAWAS
|--------------------------------------------------------------------------
*/

            Route::get('/profile', [
                ProfileController::class,
                'edit'
            ])->name('profile');

            Route::put('/profile', [
                ProfileController::class,
                'update'
            ])->name('profile.update');
        });
    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | GURU
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:guru')
        ->prefix('guru')
        ->name('guru.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD GURU
            |--------------------------------------------------------------------------
            */

            Route::get('/dashboard', function () {
                $user = Auth::user();

                abort_if(
                    !$user,
                    403,
                    'Pengguna belum login.'
                );

                $teacher = $user->teacher;

                abort_if(
                    !$teacher,
                    403,
                    'Data guru tidak ditemukan.'
                );

                $documentsQuery = \App\Models\TeacherDocument::where(
                    'teacher_id',
                    $teacher->id
                );

                $documentCount = (clone $documentsQuery)->count();

                $verifiedDocumentCount = (clone $documentsQuery)
                    ->where('status', 'verified')
                    ->count();

                return view('guru.dashboard', compact(
                    'teacher',
                    'documentCount',
                    'verifiedDocumentCount'
                ));
            })->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | DOKUMEN GURU
            |--------------------------------------------------------------------------
            */

            Route::get('/documents', [
                \App\Http\Controllers\TeacherDocumentController::class,
                'index'
            ])->name('documents.index');

            Route::post('/documents', [
                \App\Http\Controllers\TeacherDocumentController::class,
                'store'
            ])->name('documents.store');


            /*
            |--------------------------------------------------------------------------
            | PROFIL GURU
            |--------------------------------------------------------------------------
            */

            Route::get('/profile', [
                \App\Http\Controllers\GuruProfileController::class,
                'edit'
            ])->name('profile');

            Route::patch('/profile', [
                \App\Http\Controllers\GuruProfileController::class,
                'update'
            ])->name('profile.update');


            /*
            |--------------------------------------------------------------------------
            | KINERJA GURU
            |--------------------------------------------------------------------------
            */

            Route::get('/performance', [
                \App\Http\Controllers\GuruPerformanceController::class,
                'index'
            ])->name('performance');


            /*
            |--------------------------------------------------------------------------
            | HASIL PENILAIAN GURU
            |--------------------------------------------------------------------------
            */

            Route::get('/assessment', [
                \App\Http\Controllers\GuruAssessmentController::class,
                'index'
            ])->name('assessment');

        });

});


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
