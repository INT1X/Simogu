<?php

namespace App\Http\Controllers;

use App\Models\AssessmentWeight;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentWeightController extends Controller
{
    /**
     * Menampilkan daftar bobot penilaian.
     */
    public function index(): View
    {
        $weights = AssessmentWeight::orderBy('competency')->get();

        return view(
            'admin.assessment-weights.index',
            compact('weights')
        );
    }

    /**
     * Form tambah bobot.
     */
    public function create(): View
    {
        return view('admin.assessment-weights.create');
    }

    /**
     * Menyimpan bobot.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'competency' => [
                'required',
                'string',
                'max:100',
            ],

            'weight' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        AssessmentWeight::create($validated);

        return redirect()
            ->route('admin.assessment-weights.index')
            ->with(
                'success',
                'Bobot penilaian berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail.
     */
    public function show(
        AssessmentWeight $assessmentWeight
    ): View {
        return view(
            'admin.assessment-weights.show',
            compact('assessmentWeight')
        );
    }

    /**
     * Form edit.
     */
    public function edit(
        AssessmentWeight $assessmentWeight
    ): View {
        return view(
            'admin.assessment-weights.edit',
            compact('assessmentWeight')
        );
    }

    /**
     * Memperbarui bobot.
     */
    public function update(
        Request $request,
        AssessmentWeight $assessmentWeight
    ): RedirectResponse {

        $validated = $request->validate([
            'competency' => [
                'required',
                'string',
                'max:100',
            ],

            'weight' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $assessmentWeight->update($validated);

        return redirect()
            ->route('admin.assessment-weights.index')
            ->with(
                'success',
                'Bobot penilaian berhasil diperbarui.'
            );
    }

    /**
     * Menghapus bobot.
     */
    public function destroy(
        AssessmentWeight $assessmentWeight
    ): RedirectResponse {

        $assessmentWeight->delete();

        return redirect()
            ->route('admin.assessment-weights.index')
            ->with(
                'success',
                'Bobot penilaian berhasil dihapus.'
            );
    }
}