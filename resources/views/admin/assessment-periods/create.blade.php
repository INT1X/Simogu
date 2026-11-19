
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Periode Semester - SIMOGU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen w-auto">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 shrink-0 lg:hidden"></div>

                    <div class="w-2 h-8 bg-amber-500 rounded-full"></div>

                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">
                            Tambah Periode Semester
                        </h1>
                        <p class="text-slate-500 mt-1">
                            Buat periode penilaian berdasarkan tahun ajaran dan semester.
                        </p>
                    </div>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <section class="w-full p-4 sm:p-6 lg:p-8">

            {{-- BREADCRUMB --}}
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
                <a href="{{ route('admin.assessment-periods.index') }}"
                   class="hover:text-amber-600">
                    Periode Penilaian
                </a>
                <span>/</span>
                <span class="font-medium text-slate-700">Tambah Periode</span>
            </div>

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5">
                    <p class="font-semibold text-red-800 mb-2">
                        Periksa kembali data yang dimasukkan.
                    </p>

                    <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="max-w-4xl mx-auto">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    {{-- FORM HEADER --}}
                    <div class="px-6 py-5 border-b border-slate-200 bg-white">
                        <h2 class="text-lg font-bold text-slate-800">
                            Informasi Periode
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Lengkapi informasi periode penilaian yang akan dibuat.
                        </p>
                    </div>

                    <form action="{{ route('admin.assessment-periods.store') }}"
                          method="POST"
                          class="p-6">

                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- TAHUN AJARAN --}}
                            <div>
                                <label for="academic_year"
                                       class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tahun Ajaran <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="academic_year"
                                    name="academic_year"
                                    value="{{ old('academic_year') }}"
                                    placeholder="Contoh: 2026/2027"
                                    pattern="[0-9]{4}/[0-9]{4}"
                                    maxlength="9"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                                           text-slate-800 placeholder:text-slate-400
                                           focus:border-amber-500 focus:ring-2 focus:ring-amber-100
                                           outline-none transition">

                                <p class="text-xs text-slate-500 mt-2">
                                    Format tahun ajaran: 2026/2027.
                                </p>

                                @error('academic_year')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- SEMESTER --}}
                            <div>
                                <label for="semester"
                                       class="block text-sm font-semibold text-slate-700 mb-2">
                                    Semester <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="semester"
                                    name="semester"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                                           text-slate-800 bg-white
                                           focus:border-amber-500 focus:ring-2 focus:ring-amber-100
                                           outline-none transition">

                                    <option value="">Pilih semester</option>

                                    <option value="ganjil"
                                        {{ old('semester') === 'ganjil' ? 'selected' : '' }}>
                                        Semester Ganjil
                                    </option>

                                    <option value="genap"
                                        {{ old('semester') === 'genap' ? 'selected' : '' }}>
                                        Semester Genap
                                    </option>

                                </select>

                                @error('semester')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TANGGAL MULAI --}}
                            <div>
                                <label for="start_date"
                                       class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Mulai
                                </label>

                                <input
                                    type="date"
                                    id="start_date"
                                    name="start_date"
                                    value="{{ old('start_date') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                                           text-slate-800 bg-white
                                           focus:border-amber-500 focus:ring-2 focus:ring-amber-100
                                           outline-none transition">

                                <p class="text-xs text-slate-500 mt-2">
                                    Boleh dikosongkan jika belum ditentukan.
                                </p>

                                @error('start_date')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- TANGGAL SELESAI --}}
                            <div>
                                <label for="end_date"
                                       class="block text-sm font-semibold text-slate-700 mb-2">
                                    Tanggal Selesai
                                </label>

                                <input
                                    type="date"
                                    id="end_date"
                                    name="end_date"
                                    value="{{ old('end_date') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                                           text-slate-800 bg-white
                                           focus:border-amber-500 focus:ring-2 focus:ring-amber-100
                                           outline-none transition">

                                <p class="text-xs text-slate-500 mt-2">
                                    Harus sama atau setelah tanggal mulai.
                                </p>

                                @error('end_date')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- STATUS --}}
                            <div class="md:col-span-2">
                                <label for="status"
                                       class="block text-sm font-semibold text-slate-700 mb-2">
                                    Status Periode <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    required
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3
                                           text-slate-800 bg-white
                                           focus:border-amber-500 focus:ring-2 focus:ring-amber-100
                                           outline-none transition">

                                    <option value="draft"
                                        {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>
                                        Draft — Belum digunakan untuk penilaian
                                    </option>

                                    <option value="active"
                                        {{ old('status') === 'active' ? 'selected' : '' }}>
                                        Aktif — Periode yang sedang berjalan
                                    </option>

                                    <option value="closed"
                                        {{ old('status') === 'closed' ? 'selected' : '' }}>
                                        Ditutup — Periode sudah selesai
                                    </option>

                                </select>

                                <p class="text-xs text-slate-500 mt-2">
                                    Jika periode baru diatur aktif, periode aktif sebelumnya akan ditutup.
                                </p>

                                @error('status')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        {{-- ACTIONS --}}
                        <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 mt-8 pt-6 border-t border-slate-200">

                            <a href="{{ route('admin.assessment-periods.index') }}"
                               class="inline-flex items-center justify-center px-5 py-3
                                      rounded-xl border border-slate-300 text-slate-700
                                      font-semibold hover:bg-slate-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center justify-center px-5 py-3
                                           rounded-xl bg-amber-500 text-white font-semibold
                                           hover:bg-amber-600 transition shadow-sm">
                                Simpan Periode
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>

    </main>

</body>
</html>
