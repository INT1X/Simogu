<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800">

    <div class="min-h-screen">

        {{-- ========================================================= --}}
        {{-- SIDEBAR --}}
        {{-- ========================================================= --}}

        @include('components.admin-sidebar')


        {{-- ========================================================= --}}
        {{-- MAIN --}}
        {{-- ========================================================= --}}

        <main class="md:ml-64 min-h-screen">

            {{-- ===================================================== --}}
            {{-- HEADER --}}
            {{-- ===================================================== --}}

            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200">

                <div class="px-4 sm:px-6 lg:px-8 xl:px-10 py-4">

                    <div class="flex items-center justify-between gap-4">

                        {{-- Judul --}}
                        <div class="flex items-center gap-3 min-w-0">

                            <div class="hidden sm:flex w-11 h-11 rounded-xl bg-blue-50 items-center justify-center shrink-0">

                                <svg class="w-6 h-6 text-blue-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3M12 15a4 4 0 100-8 4 4 0 000 8zM5 20a7 7 0 0114 0" />

                                </svg>

                            </div>

                            <div class="min-w-0">

                                <div class="flex items-center gap-2">

                                    <h1 class="text-xl sm:text-2xl font-bold text-slate-800 truncate">
                                        Tambah Guru
                                    </h1>

                                </div>

                                <p class="text-sm text-slate-500 hidden sm:block">
                                    Tambahkan data guru dan akun login ke sistem SIMOGU.
                                </p>

                            </div>

                        </div>


                        {{-- User --}}
                        <div class="hidden sm:block text-right shrink-0">

                            <p class="font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>

                            <div class="flex items-center justify-end gap-1.5 mt-1">

                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                <span class="text-xs font-medium text-emerald-600">
                                    Administrator
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </header>


            {{-- ===================================================== --}}
            {{-- CONTENT --}}
            {{-- ===================================================== --}}

            <section class="p-4 sm:p-6 lg:p-8 xl:p-10">

                {{-- ================================================= --}}
                {{-- BREADCRUMB --}}
                {{-- ================================================= --}}

                <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">

                    <a href="{{ route('admin.dashboard') }}"
                        class="hover:text-blue-600 transition">

                        Dashboard

                    </a>

                    <svg class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7" />

                    </svg>

                    <a href="{{ route('admin.teachers.index') }}"
                        class="hover:text-blue-600 transition">

                        Data Guru

                    </a>

                    <svg class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 5l7 7-7 7" />

                    </svg>

                    <span class="text-slate-700 font-medium">
                        Tambah Guru
                    </span>

                </div>


                {{-- ================================================= --}}
                {{-- ERROR --}}
                {{-- ================================================= --}}

                @if ($errors->any())

                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">

                        <div class="flex items-start gap-3">

                            <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center shrink-0">

                                <svg class="w-5 h-5 text-red-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />

                                </svg>

                            </div>

                            <div>

                                <h3 class="font-bold text-red-800">
                                    Terdapat kesalahan
                                </h3>

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

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">


                    {{-- ================================================= --}}
                    {{-- FORM HEADER --}}
                    {{-- ================================================= --}}

                    <div class="px-5 sm:px-7 lg:px-8 py-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">

                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12 rounded-2xl bg-blue-600 flex items-center justify-center shadow-lg shadow-blue-600/20">

                                <svg class="w-6 h-6 text-white"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3M12 15a4 4 0 100-8 4 4 0 000 8zM5 20a7 7 0 0114 0" />

                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg sm:text-xl font-bold text-slate-800">
                                    Form Data Guru
                                </h2>

                                <p class="text-sm text-slate-500 mt-1">
                                    Lengkapi informasi berikut dengan benar.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FORM --}}
                    {{-- ================================================= --}}

                    <form
                        method="POST"
                        action="{{ route('admin.teachers.store') }}"
                        enctype="multipart/form-data">

                        @csrf


                        {{-- ================================================= --}}
                        {{-- DATA UTAMA --}}
                        {{-- ================================================= --}}

                        <div class="p-5 sm:p-7 lg:p-8">

                            <div class="mb-6">

                                <div class="flex items-center gap-3">

                                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center">

                                        <svg class="w-5 h-5 text-blue-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                                        </svg>

                                    </div>

                                    <div>

                                        <h3 class="font-bold text-slate-800">
                                            Informasi Guru
                                        </h3>

                                        <p class="text-xs text-slate-500">
                                            Data identitas dan informasi kepegawaian.
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- 3 KOLOM DESKTOP --}}
                            {{-- ================================================= --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">


                                {{-- FOTO --}}
                                <div class="xl:col-span-1">

                                    <label
                                        for="photo"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Foto Guru

                                    </label>

                                    <div class="relative">

                                        <input
                                            type="file"
                                            id="photo"
                                            name="photo"
                                            accept="image/jpeg,image/png,image/webp"
                                            class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm
                                                   file:mr-3 file:rounded-lg file:border-0
                                                   file:bg-blue-50 file:px-3 file:py-2
                                                   file:text-sm file:font-semibold file:text-blue-700
                                                   hover:file:bg-blue-100
                                                   focus:border-blue-500 focus:ring-blue-500">

                                    </div>

                                    <p class="text-xs text-slate-500 mt-2">
                                        JPG, JPEG, PNG atau WEBP. Maksimal 2 MB.
                                    </p>

                                    @error('photo')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- SEKOLAH --}}
                                <div>

                                    <label
                                        for="school_id"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Sekolah
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <select
                                        id="school_id"
                                        name="school_id"
                                        required
                                        class="w-full rounded-xl border-slate-300 bg-white
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                        <option value="">
                                            -- Pilih Sekolah --
                                        </option>

                                        @foreach ($schools as $school)

                                            <option
                                                value="{{ $school->id }}"
                                                {{ old('school_id') == $school->id ? 'selected' : '' }}>

                                                {{ $school->name }}

                                            </option>

                                        @endforeach

                                    </select>

                                    @error('school_id')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- NIP --}}
                                <div>

                                    <label
                                        for="nip"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        NIP

                                    </label>

                                    <input
                                        type="text"
                                        id="nip"
                                        name="nip"
                                        value="{{ old('nip') }}"
                                        placeholder="Masukkan NIP"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('nip')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- NIK --}}
                                <div>

                                    <label
                                        for="nik"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        NIK

                                    </label>

                                    <input
                                        type="text"
                                        id="nik"
                                        name="nik"
                                        value="{{ old('nik') }}"
                                        placeholder="Masukkan NIK"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('nik')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- NAMA --}}
                                <div>

                                    <label
                                        for="name"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Nama Lengkap
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required
                                        placeholder="Masukkan nama lengkap Guru"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('name')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- JENIS KELAMIN --}}
                                <div>

                                    <label
                                        for="gender"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Jenis Kelamin

                                    </label>

                                    <select
                                        id="gender"
                                        name="gender"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                        <option value="">
                                            -- Pilih Jenis Kelamin --
                                        </option>

                                        <option
                                            value="Laki-laki"
                                            {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>

                                            Laki-laki

                                        </option>

                                        <option
                                            value="Perempuan"
                                            {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>

                                            Perempuan

                                        </option>

                                    </select>

                                    @error('gender')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- MATA PELAJARAN --}}
                                <div>

                                    <label
                                        for="subject"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Mata Pelajaran

                                    </label>

                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        value="{{ old('subject') }}"
                                        placeholder="Contoh: Matematika"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('subject')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- STATUS --}}
                                <div>

                                    <label
                                        for="employment_status"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Status Kepegawaian

                                    </label>

                                    <select
                                        id="employment_status"
                                        name="employment_status"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                        <option value="">
                                            -- Pilih Status --
                                        </option>

                                        <option
                                            value="PNS"
                                            {{ old('employment_status') === 'PNS' ? 'selected' : '' }}>
                                            PNS
                                        </option>

                                        <option
                                            value="PPPK"
                                            {{ old('employment_status') === 'PPPK' ? 'selected' : '' }}>
                                            PPPK
                                        </option>

                                        <option
                                            value="Honorer"
                                            {{ old('employment_status') === 'Honorer' ? 'selected' : '' }}>
                                            Honorer
                                        </option>

                                        <option
                                            value="Non-ASN"
                                            {{ old('employment_status') === 'Non-ASN' ? 'selected' : '' }}>
                                            Non-ASN
                                        </option>

                                    </select>

                                    @error('employment_status')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- TELEPON --}}
                                <div>

                                    <label
                                        for="phone"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        No. Telepon

                                    </label>

                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('phone')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- EMAIL --}}
                                <div>

                                    <label
                                        for="email"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Email Login
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        required
                                        placeholder="guru@email.com"
                                        class="w-full rounded-xl border-slate-300
                                               px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('email')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- AKUN LOGIN --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-slate-200 bg-slate-50/70 p-5 sm:p-7 lg:p-8">

                            <div class="flex items-center gap-3 mb-6">

                                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center">

                                    <svg class="w-5 h-5 text-emerald-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v2h8z" />

                                    </svg>

                                </div>

                                <div>

                                    <h3 class="font-bold text-slate-800">
                                        Akun Login Guru
                                    </h3>

                                    <p class="text-xs text-slate-500">
                                        Email dan password digunakan untuk login Guru.
                                    </p>

                                </div>

                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">


                                {{-- PASSWORD --}}
                                <div>

                                    <label
                                        for="password"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Password
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        required
                                        minlength="8"
                                        placeholder="Minimal 8 karakter"
                                        class="w-full rounded-xl border-slate-300
                                               bg-white px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                    @error('password')

                                        <p class="text-red-600 text-xs mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- KONFIRMASI --}}
                                <div>

                                    <label
                                        for="password_confirmation"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Konfirmasi Password
                                        <span class="text-red-500">*</span>

                                    </label>

                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        required
                                        minlength="8"
                                        placeholder="Ulangi password"
                                        class="w-full rounded-xl border-slate-300
                                               bg-white px-4 py-2.5
                                               focus:border-blue-500 focus:ring-blue-500">

                                </div>


                                {{-- INFO --}}
                                <div class="rounded-xl bg-blue-50 border border-blue-100 p-4">

                                    <div class="flex gap-3">

                                        <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                                        </svg>

                                        <p class="text-xs leading-5 text-blue-700">
                                            Gunakan password minimal 8 karakter.
                                            Simpan informasi login dengan aman.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- TOMBOL --}}
                        {{-- ================================================= --}}

                        <div class="border-t border-slate-200 px-5 sm:px-7 lg:px-8 py-5">

                            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                                <a
                                    href="{{ route('admin.teachers.index') }}"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl
                                           bg-slate-100 text-slate-700 font-semibold
                                           hover:bg-slate-200 transition">

                                    <svg class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />

                                    </svg>

                                    Batal

                                </a>


                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl
                                           bg-blue-600 text-white font-semibold
                                           hover:bg-blue-700
                                           shadow-lg shadow-blue-600/20
                                           transition">

                                    <svg class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7" />

                                    </svg>

                                    Simpan Guru

                                </button>

                            </div>

                        </div>

                    </form>

                </div>

            </section>

        </main>

    </div>

</body>

</html>