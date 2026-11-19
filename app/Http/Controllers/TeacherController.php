<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TeacherController extends Controller
{
    /**
     * Daftar Guru
     */
    public function index(): View
    {
        $teachers = Teacher::with('school', 'user')
            ->latest()
            ->paginate(10);

        return view('admin.teachers.index', compact('teachers'));
    }

    /**
     * Form tambah Guru
     */
    public function create(): View
    {
        $schools = School::orderBy('name')->get();

        return view('admin.teachers.create', compact('schools'));
    }

    /**
     * Simpan Guru + akun login
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_id' => [
                'required',
                'exists:schools,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'nip' => [
                'nullable',
                'string',
                'max:50',
                'unique:teachers,nip',
            ],

            'nik' => [
                'nullable',
                'string',
                'max:50',
                'unique:teachers,nik',
            ],

            'gender' => [
                'nullable',
                'in:Laki-laki,Perempuan',
            ],

            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'employment_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Upload foto
        |--------------------------------------------------------------------------
        */

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')
                ->store('teachers', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Membuat akun User Guru
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'guru',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Membuat data Guru
        |--------------------------------------------------------------------------
        */

        Teacher::create([
            'user_id' => $user->id,
            'school_id' => $validated['school_id'],
            'photo' => $photoPath,
            'name' => $validated['name'],
            'nip' => $validated['nip'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
            'employment_status' => $validated['employment_status'] ?? null,
        ]);

        return redirect()
            ->route('admin.teachers.index')
            ->with(
                'success',
                'Data Guru dan akun login berhasil dibuat.'
            );
    }

    /**
     * Detail Guru
     */
    public function show(Teacher $teacher): View
    {
        $teacher->load('school', 'user');

        return view(
            'admin.teachers.show',
            compact('teacher')
        );
    }

    /**
     * Form edit Guru
     */
    public function edit(Teacher $teacher): View
    {
        $schools = School::orderBy('name')->get();

        $teacher->load('user');

        return view(
            'admin.teachers.edit',
            compact('teacher', 'schools')
        );
    }

    /**
     * Update Guru
     */
    public function update(
        Request $request,
        Teacher $teacher
    ): RedirectResponse {

        $teacher->load('user');

        $validated = $request->validate([
            'school_id' => [
                'required',
                'exists:schools,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'nip' => [
                'nullable',
                'string',
                'max:50',
                'unique:teachers,nip,' . $teacher->id,
            ],

            'nik' => [
                'nullable',
                'string',
                'max:50',
                'unique:teachers,nik,' . $teacher->id,
            ],

            'gender' => [
                'nullable',
                'in:Laki-laki,Perempuan',
            ],

            'subject' => [
                'nullable',
                'string',
                'max:255',
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $teacher->user_id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'employment_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Foto baru
        |--------------------------------------------------------------------------
        */

        $photoPath = $teacher->photo;

        if ($request->hasFile('photo')) {

            if ($teacher->photo) {
                Storage::disk('public')
                    ->delete($teacher->photo);
            }

            $photoPath = $request->file('photo')
                ->store('teachers', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update akun User
        |--------------------------------------------------------------------------
        */

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $userData['password'] = Hash::make(
                $validated['password']
            );
        }

        if ($teacher->user) {
            $teacher->user->update($userData);
        }

        /*
        |--------------------------------------------------------------------------
        | Update data Guru
        |--------------------------------------------------------------------------
        */

        $teacher->update([
            'school_id' => $validated['school_id'],
            'photo' => $photoPath,
            'name' => $validated['name'],
            'nip' => $validated['nip'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'subject' => $validated['subject'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
            'employment_status' =>
                $validated['employment_status'] ?? null,
        ]);

        return redirect()
            ->route('admin.teachers.index')
            ->with(
                'success',
                'Data Guru berhasil diperbarui.'
            );
    }

    /**
     * Hapus Guru dan akun login
     */
    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->load('user');

        /*
        |--------------------------------------------------------------------------
        | Hapus foto
        |--------------------------------------------------------------------------
        */

        if ($teacher->photo) {
            Storage::disk('public')
                ->delete($teacher->photo);
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus akun User
        |--------------------------------------------------------------------------
        */

        if ($teacher->user) {
            $teacher->user->delete();
        }

        /*
        |--------------------------------------------------------------------------
        | Hapus data Guru
        |--------------------------------------------------------------------------
        */

        $teacher->delete();

        return redirect()
            ->route('admin.teachers.index')
            ->with(
                'success',
                'Data Guru dan akun login berhasil dihapus.'
            );
    }
}