<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentTypeController extends Controller
{
    public function index(): View
    {
        $documentTypes = DocumentType::latest()
            ->paginate(10);

        return view(
            'admin.document-types.index',
            compact('documentTypes')
        );
    }

    public function create(): View
    {
        return view('admin.document-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'max_score' => [
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

        DocumentType::create($validated);

        return redirect()
            ->route('admin.document-types.index')
            ->with(
                'success',
                'Jenis berkas berhasil ditambahkan.'
            );
    }

    public function show(
        DocumentType $documentType
    ): View {
        return view(
            'admin.document-types.show',
            compact('documentType')
        );
    }

    public function edit(
        DocumentType $documentType
    ): View {
        return view(
            'admin.document-types.edit',
            compact('documentType')
        );
    }

    public function update(
        Request $request,
        DocumentType $documentType
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'max_score' => [
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

        $documentType->update($validated);

        return redirect()
            ->route('admin.document-types.index')
            ->with(
                'success',
                'Jenis berkas berhasil diperbarui.'
            );
    }

    public function destroy(
        DocumentType $documentType
    ): RedirectResponse {
        $documentType->delete();

        return redirect()
            ->route('admin.document-types.index')
            ->with(
                'success',
                'Jenis berkas berhasil dihapus.'
            );
    }
}