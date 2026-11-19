<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DocumentTypeController extends Controller
{
    /**
     * Menampilkan daftar jenis dokumen.
     */
    public function index(): View
    {
        $documentTypes = DocumentType::latest()->get();

        return view(
            'admin.document-types.index',
            compact('documentTypes')
        );
    }

    /**
     * Menampilkan form tambah jenis dokumen.
     */
    public function create(): View
    {
        return view('admin.document-types.create');
    }

    /**
     * Menyimpan jenis dokumen baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:document_types,name',
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

        DocumentType::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'max_score' => $validated['max_score'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.document-types.index')
            ->with(
                'success',
                'Jenis dokumen berhasil ditambahkan.'
            );
    }

    /**
     * Menampilkan detail jenis dokumen.
     */
    public function show(DocumentType $documentType): View
    {
        return view(
            'admin.document-types.show',
            compact('documentType')
        );
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(DocumentType $documentType): View
    {
        return view(
            'admin.document-types.edit',
            compact('documentType')
        );
    }

    /**
     * Memperbarui jenis dokumen.
     */
    public function update(
        Request $request,
        DocumentType $documentType
    ): RedirectResponse {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:document_types,name,' . $documentType->id,
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

        $documentType->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'max_score' => $validated['max_score'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.document-types.index')
            ->with(
                'success',
                'Jenis dokumen berhasil diperbarui.'
            );
    }

    /**
     * Menghapus jenis dokumen.
     */
    public function destroy(
        DocumentType $documentType
    ): RedirectResponse {

        $documentType->delete();

        return redirect()
            ->route('admin.document-types.index')
            ->with(
                'success',
                'Jenis dokumen berhasil dihapus.'
            );
    }
}