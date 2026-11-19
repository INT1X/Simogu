<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolController extends Controller
{
    /**
     * Menampilkan daftar sekolah.
     */
    public function index(): View
    {
        $schools = School::latest()->paginate(10);

        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Menampilkan form tambah sekolah.
     */
    public function create(): View
    {
        return view('admin.schools.create');
    }

    /**
     * Menyimpan data sekolah baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => [
                'required',
                'string',
                'max:50',
                'unique:schools,npsn',
            ],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        School::create($validated);

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Data sekolah berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail sekolah.
     */
    public function show(School $school): View
    {
        return view('admin.schools.show', compact('school'));
    }

    /**
     * Menampilkan form edit sekolah.
     */
    public function edit(School $school): View
    {
        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Memperbarui data sekolah.
     */
    public function update(
        Request $request,
        School $school
    ): RedirectResponse {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'npsn' => [
                'required',
                'string',
                'max:50',
                'unique:schools,npsn,' . $school->id,
            ],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $school->update($validated);

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Data sekolah berhasil diperbarui.');
    }

    /**
     * Menghapus sekolah.
     */
    public function destroy(School $school): RedirectResponse
    {
        $school->delete();

        return redirect()
            ->route('admin.schools.index')
            ->with('success', 'Data sekolah berhasil dihapus.');
    }
}