<?php

namespace App\Http\Controllers;

use App\Models\AssessmentIndicator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentIndicatorController extends Controller
{
    /**
     * Menampilkan daftar indikator.
     */
    public function index(): View
    {
        $indicators = AssessmentIndicator::orderBy('competency')
            ->orderBy('code')
            ->paginate(10);

        return view(
            'admin.assessment-indicators.index',
            compact('indicators')
        );
    }

    /**
     * Form tambah indikator.
     */
    public function create(): View
    {
        return view(
            'admin.assessment-indicators.create'
        );
    }

    /**
     * Simpan indikator.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:assessment_indicators,code',
            ],

            'competency' => [
                'required',
                'string',
                'max:100',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
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

        $validated['is_active'] =
            $request->boolean('is_active');

        AssessmentIndicator::create($validated);

        return redirect()
            ->route('admin.assessment-indicators.index')
            ->with(
                'success',
                'Indikator penilaian berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail indikator.
     */
    public function show(
        AssessmentIndicator $assessmentIndicator
    ): View {

        $assessmentIndicator->load(
            'assessmentDetails.assessment'
        );

        return view(
            'admin.assessment-indicators.show',
            compact('assessmentIndicator')
        );
    }

    /**
     * Form edit indikator.
     */
    public function edit(
        AssessmentIndicator $assessmentIndicator
    ): View {

        return view(
            'admin.assessment-indicators.edit',
            compact('assessmentIndicator')
        );
    }

    /**
     * Update indikator.
     */
    public function update(
        Request $request,
        AssessmentIndicator $assessmentIndicator
    ): RedirectResponse {

        $validated = $request->validate([
            'code' => [
                'required',
                'string',
                'max:50',
                'unique:assessment_indicators,code,' .
                    $assessmentIndicator->id,
            ],

            'competency' => [
                'required',
                'string',
                'max:100',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
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

        $validated['is_active'] =
            $request->boolean('is_active');

        $assessmentIndicator->update($validated);

        return redirect()
            ->route('admin.assessment-indicators.index')
            ->with(
                'success',
                'Indikator penilaian berhasil diperbarui.'
            );
    }

    /**
     * Hapus indikator.
     */
    public function destroy(
        AssessmentIndicator $assessmentIndicator
    ): RedirectResponse {

        if (
            $assessmentIndicator
                ->assessmentDetails()
                ->exists()
        ) {
            return redirect()
                ->route('admin.assessment-indicators.index')
                ->with(
                    'error',
                    'Indikator tidak dapat dihapus karena sudah digunakan dalam penilaian.'
                );
        }

        $assessmentIndicator->delete();

        return redirect()
            ->route('admin.assessment-indicators.index')
            ->with(
                'success',
                'Indikator penilaian berhasil dihapus.'
            );
    }
}