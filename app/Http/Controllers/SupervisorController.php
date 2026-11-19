<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Supervisor;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    /**
     * Menampilkan daftar pengawas.
     */
    public function index(): View
    {
        $supervisors = Supervisor::with(['school', 'user'])
            ->latest()
            ->paginate(10);

        return view(
            'admin.supervisors.index',
            compact('supervisors')
        );
    }

    /**
     * Menampilkan form tambah pengawas.
     */
    public function create(): View
    {
        $schools = School::orderBy('name')->get();

        return view(
            'admin.supervisors.create',
            compact('schools')
        );
    }

    /**
     * Menyimpan pengawas sekaligus membuat akun login.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'school_id' => [
                'required',
                'exists:schools,id',
            ],

            'nip' => [
                'required',
                'string',
                'max:50',
                'unique:supervisors,nip',
            ],

            'name' => [
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

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],
        ]);

        DB::transaction(function () use ($request, $validated) {

            /*
            |--------------------------------------------------------------------------
            | Buat akun User
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'pengawas',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Upload foto
            |--------------------------------------------------------------------------
            */

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $photoPath = $request
                    ->file('photo')
                    ->store('supervisors', 'public');
            }

            /*
            |--------------------------------------------------------------------------
            | Buat data Supervisor
            |--------------------------------------------------------------------------
            */

            Supervisor::create([
                'user_id' => $user->id,
                'school_id' => $validated['school_id'],
                'nip' => $validated['nip'],
                'name' => $validated['name'],
                'photo' => $photoPath,
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()
            ->route('admin.supervisors.index')
            ->with(
                'success',
                'Data pengawas dan akun login berhasil dibuat.'
            );
    }

    /**
     * Menampilkan detail pengawas.
     */
    public function show(Supervisor $supervisor): View
    {
        $supervisor->load([
            'school',
            'user',
        ]);

        return view(
            'admin.supervisors.show',
            compact('supervisor')
        );
    }

    /**
     * Menampilkan form edit pengawas.
     */
    public function edit(Supervisor $supervisor): View
    {
        $schools = School::orderBy('name')->get();

        $supervisor->load('user');

        return view(
            'admin.supervisors.edit',
            compact(
                'supervisor',
                'schools'
            )
        );
    }

    /**
     * Memperbarui data pengawas dan akun login.
     */
    public function update(
        Request $request,
        Supervisor $supervisor
    ): RedirectResponse {

        $validated = $request->validate([
            'school_id' => [
                'required',
                'exists:schools,id',
            ],

            'nip' => [
                'required',
                'string',
                'max:50',
                'unique:supervisors,nip,' . $supervisor->id,
            ],

            'name' => [
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

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . ($supervisor->user_id ?? 'NULL'),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],

            'status' => [
                'required',
                'in:aktif,nonaktif',
            ],
        ]);

        DB::transaction(function () use ($request, $validated, $supervisor) {

            /*
            |--------------------------------------------------------------------------
            | Update akun User
            |--------------------------------------------------------------------------
            */

            $user = $supervisor->user;

            if ($user) {

                $user->name = $validated['name'];
                $user->email = $validated['email'];
                $user->role = 'pengawas';

                if (!empty($validated['password'])) {
                    $user->password = Hash::make(
                        $validated['password']
                    );
                }

                $user->save();

                // Sinkronisasi email ke tabel supervisors
                $supervisor->email = $validated['email'];
            }

            /*
            |--------------------------------------------------------------------------
            | Upload foto baru
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('photo')) {

                if ($supervisor->photo) {
                    Storage::disk('public')->delete(
                        $supervisor->photo
                    );
                }

                $validated['photo'] = $request
                    ->file('photo')
                    ->store('supervisors', 'public');
            }

            /*
            |--------------------------------------------------------------------------
            | Jangan masukkan field password ke Supervisor
            |--------------------------------------------------------------------------
            */

            unset($validated['email']);
            unset($validated['password']);
            unset($validated['password_confirmation']);

            /*
            |--------------------------------------------------------------------------
            | Update Supervisor
            |--------------------------------------------------------------------------
            */

            $supervisor->update($validated);
        });

        return redirect()
            ->route('admin.supervisors.index')
            ->with(
                'success',
                'Data pengawas dan akun login berhasil diperbarui.'
            );
    }

    /**
     * Menghapus pengawas beserta akun User dan foto.
     */
    public function destroy(
        Supervisor $supervisor
    ): RedirectResponse {

        DB::transaction(function () use ($supervisor) {

            /*
            |--------------------------------------------------------------------------
            | Hapus foto
            |--------------------------------------------------------------------------
            */

            if ($supervisor->photo) {
                Storage::disk('public')->delete(
                    $supervisor->photo
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan user sebelum supervisor dihapus
            |--------------------------------------------------------------------------
            */

            $user = $supervisor->user;

            /*
            |--------------------------------------------------------------------------
            | Hapus supervisor
            |--------------------------------------------------------------------------
            */

            $supervisor->delete();

            /*
            |--------------------------------------------------------------------------
            | Hapus akun login pengawas
            |--------------------------------------------------------------------------
            */

            if ($user) {
                $user->delete();
            }
        });

        return redirect()
            ->route('admin.supervisors.index')
            ->with(
                'success',
                'Data pengawas dan akun login berhasil dihapus.'
            );
    }
}