<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentIndicator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentIndicatorController extends Controller
{
    public function index(): View
    {
        $indicators = AssessmentIndicator::latest()->paginate(10);

        return view(
            'admin.assessment-indicators.index',
            compact('indicators')
        );
    }

    public function create(): View
    {
        return view('admin.assessment-indicators.create');
    }

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
                'max:255',
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

    public function show(
        AssessmentIndicator $assessmentIndicator
    ): View {
        return view(
            'admin.assessment-indicators.show',
            compact('assessmentIndicator')
        );
    }

    public function edit(
        AssessmentIndicator $assessmentIndicator
    ): View {
        return view(
            'admin.assessment-indicators.edit',
            compact('assessmentIndicator')
        );
    }

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
                'max:255',
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

    public function destroy(
        AssessmentIndicator $assessmentIndicator
    ): RedirectResponse {
        $assessmentIndicator->delete();

        return redirect()
            ->route('admin.assessment-indicators.index')
            ->with(
                'success',
                'Indikator penilaian berhasil dihapus.'
            );
    }
}