<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Indikator - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

@include('components.admin-sidebar')

<main class="lg:ml-64 min-h-screen">

    <header class="bg-white border-b border-slate-200">

        <div class="px-4 sm:px-6 lg:px-8 py-5">

            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Tambah Indikator Penilaian
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Tambahkan indikator baru untuk penilaian kinerja guru.
            </p>

        </div>

    </header>


    <section class="p-4 sm:p-6 lg:p-8">

        @if($errors->any())

            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4">

                <p class="font-semibold text-red-800">
                    Terdapat kesalahan:
                </p>

                <ul class="mt-2 list-disc list-inside text-sm text-red-700">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('admin.assessment-indicators.store') }}"
        >

            @csrf


            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                <div class="p-5 sm:p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- KODE --}}

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Kode Indikator
                            </label>

                            <input
                                type="text"
                                name="code"
                                value="{{ old('code') }}"
                                required
                                maxlength="50"
                                placeholder="Contoh: PED-01"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                        </div>


                        {{-- KOMPETENSI --}}

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Kompetensi
                            </label>

                            <input
                                type="text"
                                name="competency"
                                value="{{ old('competency') }}"
                                required
                                maxlength="100"
                                placeholder="Contoh: Pedagogik"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                        </div>


                        {{-- NAMA --}}

                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Indikator
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                maxlength="255"
                                placeholder="Masukkan nama indikator"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                        </div>


                        {{-- DESKRIPSI --}}

                        <div class="md:col-span-2">

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Deskripsi
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                placeholder="Deskripsi indikator..."
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >{{ old('description') }}</textarea>

                        </div>


                        {{-- BOBOT --}}

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Bobot Indikator (%)
                            </label>

                            <input
                                type="number"
                                name="weight"
                                value="{{ old('weight', 0) }}"
                                required
                                min="0"
                                max="100"
                                step="0.01"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                        </div>


                        {{-- STATUS --}}

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Status
                            </label>

                            <label class="inline-flex items-center gap-3 mt-3">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                                >

                                <span class="text-sm text-slate-700">
                                    Indikator aktif
                                </span>

                            </label>

                        </div>

                    </div>

                </div>


                <div class="px-5 sm:px-6 py-5 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row justify-end gap-3">

                    <a
                        href="{{ route('admin.assessment-indicators.index') }}"
                        class="px-6 py-3 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-center"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold"
                    >
                        Simpan Indikator
                    </button>

                </div>

            </div>

        </form>

    </section>

</main>

</body>
</html>