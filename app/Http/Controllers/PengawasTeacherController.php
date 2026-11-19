<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PengawasTeacherController extends Controller
{
    /**
     * Menampilkan daftar guru binaan pengawas.
     *
     * Guru binaan ditentukan otomatis berdasarkan sekolah
     * yang menjadi tanggung jawab pengawas yang sedang login.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil data pengawas yang sedang login
        |--------------------------------------------------------------------------
        */

        $supervisor = Supervisor::with('school')
            ->where('user_id', Auth::id())
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Query guru binaan
        |--------------------------------------------------------------------------
        |
        | Semua guru yang berada di sekolah yang sama dengan
        | school_id milik pengawas dianggap sebagai guru binaan.
        |
        */

        $query = Teacher::with([
            'school',
            'user',
        ])
            ->where(
                'school_id',
                $supervisor->school_id
            );


        /*
        |--------------------------------------------------------------------------
        | PENCARIAN
        |--------------------------------------------------------------------------
        |
        | Pengawas dapat mencari berdasarkan:
        |
        | - Nama
        | - NIP
        | - Email
        |
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )

                    ->orWhere(
                        'nip',
                        'like',
                        '%' . $search . '%'
                    )

                    ->orWhere(
                        'email',
                        'like',
                        '%' . $search . '%'
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | STATUS GURU
        |--------------------------------------------------------------------------
        |
        | Jika tabel teachers memiliki kolom status,
        | pencarian status dapat digunakan.
        |
        | Contoh:
        | ?status=aktif
        |
        */

        if (
            $request->filled('status')
            && in_array(
                $request->input('status'),
                ['aktif', 'nonaktif'],
                true
            )
        ) {

            $query->where(
                'status',
                $request->input('status')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | URUTKAN DATA
        |--------------------------------------------------------------------------
        */

        $query->orderBy(
            'name',
            'asc'
        );


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $teachers = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | STATISTIK
        |--------------------------------------------------------------------------
        |
        | Statistik dihitung khusus untuk sekolah pengawas.
        |
        */

        $totalTeachers = Teacher::where(
            'school_id',
            $supervisor->school_id
        )->count();


        /*
        |--------------------------------------------------------------------------
        | GURU AKTIF
        |--------------------------------------------------------------------------
        |
        | Hanya digunakan jika tabel teachers mempunyai kolom status.
        |
        */

        $activeTeachers = Teacher::where(
            'school_id',
            $supervisor->school_id
        )
            ->where(
                'status',
                'aktif'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | GURU NONAKTIF
        |--------------------------------------------------------------------------
        */

        $inactiveTeachers = Teacher::where(
            'school_id',
            $supervisor->school_id
        )
            ->where(
                'status',
                'nonaktif'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pengawas.teachers.index',
            compact(
                'supervisor',
                'teachers',
                'totalTeachers',
                'activeTeachers',
                'inactiveTeachers'
            )
        );
    }


    /**
     * Menampilkan detail satu guru binaan.
     */
    public function show(Teacher $teacher): View
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil pengawas yang sedang login
        |--------------------------------------------------------------------------
        */

        $supervisor = Supervisor::with('school')
            ->where(
                'user_id',
                Auth::id()
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | KEAMANAN
        |--------------------------------------------------------------------------
        |
        | Pengawas hanya boleh melihat guru yang berada
        | di sekolah binaannya.
        |
        */

        abort_unless(
            (int) $teacher->school_id ===
                (int) $supervisor->school_id,
            403,
            'Anda tidak memiliki akses ke guru ini.'
        );


        /*
        |--------------------------------------------------------------------------
        | LOAD RELASI
        |--------------------------------------------------------------------------
        */

        $teacher->load([
            'school',
            'user',
        ]);


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'pengawas.teachers.show',
            compact(
                'supervisor',
                'teacher'
            )
        );
    }
}
