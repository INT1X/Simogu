<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Sekolah - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 min-h-screen">

    {{-- ========================================================= --}}
    {{-- SIDEBAR ADMIN --}}
    {{-- ========================================================= --}}

    @include('components.admin-sidebar')


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="min-h-screen lg:ml-72">

        {{-- Container --}}
        <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            <div class="max-w-4xl mx-auto">


                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    {{-- Breadcrumb --}}
                    <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500 mb-3">

                        <a
                            href="{{ route('admin.schools.index') }}"
                            class="hover:text-blue-600 transition"
                        >
                            Data Sekolah
                        </a>

                        <span class="text-slate-400">
                            /
                        </span>

                        <a
                            href="{{ route('admin.schools.show', $school) }}"
                            class="hover:text-blue-600 transition truncate max-w-[200px]"
                        >
                            {{ $school->name }}
                        </a>

                        <span class="text-slate-400">
                            /
                        </span>

                        <span class="text-slate-600 font-medium">
                            Edit
                        </span>

                    </div>


                    {{-- Judul --}}
                    <div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Edit Sekolah
                        </h1>

                        <p class="mt-1 text-sm sm:text-base text-slate-500">
                            Perbarui informasi data sekolah pada sistem SIMOGU.
                        </p>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- ERROR --}}
                {{-- ================================================= --}}

                @if ($errors->any())

                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                        <div class="flex items-start gap-3">

                            {{-- Icon --}}
                            <div class="flex-shrink-0">

                                <div class="w-9 h-9 rounded-xl bg-red-100 flex items-center justify-center">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 text-red-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.48 0z"
                                        />
                                    </svg>

                                </div>

                            </div>


                            {{-- Pesan --}}
                            <div class="min-w-0">

                                <p class="font-semibold text-red-700">
                                    Terdapat kesalahan
                                </p>

                                <ul class="mt-2 list-disc list-inside text-sm text-red-600 space-y-1">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- FORM CARD --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


                    {{-- ================================================= --}}
                    {{-- CARD HEADER --}}
                    {{-- ================================================= --}}

                    <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                        <div class="flex items-center gap-3">

                            {{-- Icon --}}
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-blue-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                    />
                                </svg>

                            </div>


                            {{-- Judul --}}
                            <div class="min-w-0">

                                <h2 class="font-bold text-slate-800">
                                    Informasi Sekolah
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Ubah data sekolah sesuai informasi terbaru.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FORM --}}
                    {{-- ================================================= --}}

                    <form
                        action="{{ route('admin.schools.update', $school) }}"
                        method="POST"
                    >

                        @csrf

                        @method('PUT')


                        {{-- Form Body --}}
                        <div class="p-5 sm:p-6 space-y-6">


                            {{-- ================================================= --}}
                            {{-- NAMA SEKOLAH --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="name"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Nama Sekolah
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $school->name) }}"
                                    required
                                    autocomplete="organization"
                                    placeholder="Contoh: SMP Negeri 1 Tondano"
                                    class="w-full rounded-xl border-slate-300
                                           bg-white
                                           px-4 py-3
                                           text-slate-800
                                           placeholder-slate-400
                                           focus:border-blue-500
                                           focus:ring-blue-500
                                           transition"
                                >

                            </div>


                            {{-- ================================================= --}}
                            {{-- NPSN --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="npsn"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    NPSN
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="npsn"
                                    name="npsn"
                                    value="{{ old('npsn', $school->npsn) }}"
                                    required
                                    inputmode="numeric"
                                    placeholder="Masukkan NPSN"
                                    class="w-full rounded-xl border-slate-300
                                           bg-white
                                           px-4 py-3
                                           text-slate-800
                                           placeholder-slate-400
                                           focus:border-blue-500
                                           focus:ring-blue-500
                                           transition"
                                >

                                <p class="mt-1.5 text-xs text-slate-500">
                                    NPSN harus unik untuk setiap sekolah.
                                </p>

                            </div>


                            {{-- ================================================= --}}
                            {{-- ALAMAT --}}
                            {{-- ================================================= --}}

                            <div>

                                <label
                                    for="address"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Alamat Sekolah
                                </label>

                                <textarea
                                    id="address"
                                    name="address"
                                    rows="4"
                                    placeholder="Masukkan alamat lengkap sekolah"
                                    class="w-full rounded-xl border-slate-300
                                           bg-white
                                           px-4 py-3
                                           text-slate-800
                                           placeholder-slate-400
                                           resize-y
                                           focus:border-blue-500
                                           focus:ring-blue-500
                                           transition"
                                >{{ old('address', $school->address) }}</textarea>

                            </div>


                            {{-- ================================================= --}}
                            {{-- GRID TELEPON & EMAIL --}}
                            {{-- ================================================= --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                                {{-- TELEPON --}}
                                <div>

                                    <label
                                        for="phone"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        No. Telepon
                                    </label>

                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone', $school->phone) }}"
                                        inputmode="tel"
                                        placeholder="Contoh: 0431-123456"
                                        class="w-full rounded-xl border-slate-300
                                               bg-white
                                               px-4 py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               focus:border-blue-500
                                               focus:ring-blue-500
                                               transition"
                                    >

                                </div>


                                {{-- EMAIL --}}
                                <div>

                                    <label
                                        for="email"
                                        class="block text-sm font-semibold text-slate-700 mb-2"
                                    >
                                        Email Sekolah
                                    </label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', $school->email) }}"
                                        autocomplete="email"
                                        placeholder="Contoh: sekolah@example.com"
                                        class="w-full rounded-xl border-slate-300
                                               bg-white
                                               px-4 py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               focus:border-blue-500
                                               focus:ring-blue-500
                                               transition"
                                    >

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- FOOTER FORM --}}
                        {{-- ================================================= --}}

                        <div class="px-5 sm:px-6 py-5 bg-slate-50 border-t border-slate-200">

                            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3">


                                {{-- BATAL --}}
                                <a
                                    href="{{ route('admin.schools.show', $school) }}"
                                    class="w-full sm:w-auto
                                           inline-flex items-center justify-center
                                           px-5 py-3
                                           rounded-xl
                                           bg-white
                                           border border-slate-300
                                           text-slate-700
                                           font-semibold
                                           hover:bg-slate-100
                                           transition"
                                >
                                    Batal
                                </a>


                                {{-- SIMPAN --}}
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto
                                           inline-flex items-center justify-center gap-2
                                           px-5 py-3
                                           rounded-xl
                                           bg-blue-600
                                           text-white
                                           font-semibold
                                           hover:bg-blue-700
                                           transition
                                           shadow-sm"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>

                                    Simpan Perubahan

                                </button>

                            </div>

                        </div>

                    </form>

                </div>


                {{-- ================================================= --}}
                {{-- CATATAN --}}
                {{-- ================================================= --}}

                <div class="mt-5 px-1">

                    <p class="text-xs text-slate-500">
                        <span class="text-red-500">*</span>
                        Menandakan bahwa field wajib diisi.
                    </p>

                </div>

            </div>

        </div>

    </main>


    {{-- ========================================================= --}}
    {{-- MOBILE SPACING --}}
    {{-- ========================================================= --}}

    <style>
        @media (max-width: 1023px) {

            main {
                padding-top: 3.5rem;
            }

        }
    </style>

</body>

</html>