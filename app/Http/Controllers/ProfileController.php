<?php

namespace App\Http\Controllers;

use App\Models\Supervisor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil pengawas.
     */
    public function edit(): View
    {
        $supervisor = Supervisor::with([
            'school',
            'user',
        ])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view(
            'pengawas.profile.edit',
            compact('supervisor')
        );
    }

    /**
     * Memperbarui profil pengawas.
     */
    public function update(Request $request): RedirectResponse
    {
        $supervisor = Supervisor::with('user')
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
                'unique:supervisors,nip,' . $supervisor->id,
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
                'unique:users,email,' . $supervisor->user_id,
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
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

        $photoPath = $supervisor->photo;

        if ($request->hasFile('photo')) {

            if ($supervisor->photo) {
                Storage::disk('public')
                    ->delete($supervisor->photo);
            }

            $photoPath = $request->file('photo')
                ->store('supervisors', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update akun user
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

        if ($supervisor->user) {
            $supervisor->user->update($userData);
        }

        /*
        |--------------------------------------------------------------------------
        | Update data pengawas
        |--------------------------------------------------------------------------
        */

        $supervisor->update([
            'name' => $validated['name'],
            'nip' => $validated['nip'],
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'],
            'photo' => $photoPath,
        ]);

        return redirect()
            ->route('pengawas.profile')
            ->with(
                'success',
                'Profil pengawas berhasil diperbarui.'
            );
    }
}