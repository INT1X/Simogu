<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GuruProfileController extends Controller
{
    /**
     * Menampilkan profil guru yang sedang login.
     */
    public function edit(): View
    {
        $teacher = Teacher::with([
            'user',
            'school',
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view(
            'guru.profile.edit',
            compact('teacher')
        );
    }

    /**
     * Memperbarui profil guru yang sedang login.
     */
    public function update(Request $request): RedirectResponse
    {
        $teacher = Teacher::with([
            'user',
            'school',
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'nip' => [
                'required',
                'string',
                'max:50',
                'unique:teachers,nip,' . $teacher->id,
            ],

            'nik' => [
                'required',
                'string',
                'max:50',
                'unique:teachers,nik,' . $teacher->id,
            ],

            'gender' => [
                'required',
                'string',
                'in:Laki-laki,Perempuan',
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

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        /*
         * Pertahankan foto lama jika
         * tidak ada foto baru.
         */
        $photoPath = $teacher->photo;

        /*
         * Jika guru mengunggah foto baru,
         * hapus foto lama kemudian simpan foto baru.
         */
        if ($request->hasFile('photo')) {

            if ($teacher->photo) {
                Storage::disk('public')->delete(
                    $teacher->photo
                );
            }

            $photoPath = $request
                ->file('photo')
                ->store('teachers', 'public');
        }

        /*
         * Sinkronisasi data akun User.
         */
        if ($teacher->user) {

            $teacher->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);
        }

        /*
         * Perbarui data Teacher.
         *
         * school_id, user_id, status,
         * dan employment_status sengaja
         * tidak diubah melalui profil guru.
         */
        $teacher->update([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'nik' => $validated['nik'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'photo' => $photoPath,
        ]);

        return redirect()
            ->route('guru.profile')
            ->with(
                'success',
                'Profil guru berhasil diperbarui.'
            );
    }
}