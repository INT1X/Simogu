<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Bobot Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                    Tambah Bobot Penilaian
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Tambahkan bobot kompetensi penilaian.
                </p>

            </div>

        </header>


        <section class="p-4 sm:p-6 lg:p-8">

            <div class="max-w-3xl">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

                    <div class="p-5 sm:p-6 border-b border-slate-200">

                        <h2 class="font-bold text-lg text-slate-800">
                            Form Bobot Penilaian
                        </h2>

                    </div>


                    <form
                        method="POST"
                        action="{{ route('admin.assessment-weights.store') }}"
                        class="p-5 sm:p-6"
                    >

                        @csrf


                        {{-- KOMPETENSI --}}
                        <div class="mb-5">

                            <label
                                for="competency"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Kompetensi

                                <span class="text-red-500">*</span>

                            </label>

                            <input
                                type="text"
                                name="competency"
                                id="competency"
                                value="{{ old('competency') }}"
                                required
                                maxlength="100"
                                placeholder="Contoh: Pedagogik"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                            @error('competency')

                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- BOBOT --}}
                        <div class="mb-5">

                            <label
                                for="weight"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >

                                Bobot (%)

                                <span class="text-red-500">*</span>

                            </label>

                            <input
                                type="number"
                                name="weight"
                                id="weight"
                                value="{{ old('weight') }}"
                                required
                                min="0"
                                max="100"
                                step="0.01"
                                placeholder="Contoh: 25"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                            <p class="text-xs text-slate-400 mt-2">
                                Nilai bobot berada pada rentang 0 sampai 100 persen.
                            </p>

                            @error('weight')

                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- STATUS --}}
                        <div class="mb-6">

                            <label class="inline-flex items-center gap-3">

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-slate-300 text-purple-600 focus:ring-purple-500"
                                >

                                <span class="text-sm font-semibold text-slate-700">
                                    Aktif
                                </span>

                            </label>

                        </div>


                        {{-- BUTTON --}}
                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                            <a
                                href="{{ route('admin.assessment-weights.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold"
                            >

                                Simpan Bobot

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>

    </main>

</body>

</html>