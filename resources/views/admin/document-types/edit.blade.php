<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Jenis Dokumen - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')


    <main class="lg:ml-64 min-h-screen">

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-6 py-6">

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                    Edit Jenis Dokumen
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Perbarui informasi jenis dokumen.
                </p>

            </div>

        </header>


        <section class="p-4 sm:p-6 lg:p-8">

            <div class="mb-6">

                <a
                    href="{{ route('admin.document-types.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-purple-600"
                >

                    ← Kembali ke Jenis Dokumen

                </a>

            </div>


            @if ($errors->any())

                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-5 py-4">

                    <p class="font-semibold text-red-700">
                        Terdapat kesalahan pada data.
                    </p>

                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="max-w-3xl">

                <form
                    method="POST"
                    action="{{ route('admin.document-types.update', $documentType) }}"
                    class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden"
                >

                    @csrf

                    @method('PUT')


                    <div class="px-6 py-5 border-b border-slate-200">

                        <h2 class="font-bold text-slate-800 text-lg">
                            Informasi Jenis Dokumen
                        </h2>

                    </div>


                    <div class="p-6 space-y-5">


                        {{-- NAMA --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Nama Dokumen
                                <span class="text-red-500">*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $documentType->name) }}"
                                required
                                maxlength="255"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                        </div>


                        {{-- DESKRIPSI --}}
                        <div>

                            <label
                                for="description"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Deskripsi

                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >{{ old('description', $documentType->description) }}</textarea>

                        </div>


                        {{-- NILAI --}}
                        <div>

                            <label
                                for="max_score"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Nilai Maksimal
                                <span class="text-red-500">*</span>

                            </label>

                            <input
                                type="number"
                                id="max_score"
                                name="max_score"
                                value="{{ old('max_score', $documentType->max_score) }}"
                                required
                                min="0"
                                max="100"
                                step="0.01"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                        </div>


                        {{-- STATUS --}}
                        <div>

                            <label
                                for="is_active"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Status

                            </label>

                            <select
                                id="is_active"
                                name="is_active"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                                <option
                                    value="1"
                                    {{ old('is_active', $documentType->is_active ? '1' : '0') == '1' ? 'selected' : '' }}
                                >
                                    Aktif
                                </option>

                                <option
                                    value="0"
                                    {{ old('is_active', $documentType->is_active ? '1' : '0') == '0' ? 'selected' : '' }}
                                >
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                    </div>


                    <div class="px-6 py-5 bg-slate-50 border-t border-slate-200 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                        <a
                            href="{{ route('admin.document-types.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 font-semibold"
                        >
                            Batal
                        </a>


                        <button
                            type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold"
                        >

                            Perbarui Jenis Dokumen

                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</body>

</html>