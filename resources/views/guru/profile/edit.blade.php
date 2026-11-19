<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Saya - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body class="bg-slate-100">

    <div class="min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.guru-sidebar')

        {{-- AREA UTAMA --}}
        <div class="md:ml-72 min-h-screen">

            {{-- HEADER --}}
            <header class="sticky top-0 z-30 bg-white border-b border-slate-200">

                <div class="px-4 sm:px-6 lg:px-8 py-4">

                    <div class="flex items-center justify-between gap-4">

                        {{-- KIRI --}}
                        <div class="flex items-center gap-3">

                            {{-- Hamburger --}}
                            <button
                                id="guruSidebarToggle"
                                type="button"
                                class="md:hidden w-10 h-10 rounded-lg
                                       bg-slate-900 text-white
                                       flex items-center justify-center
                                       hover:bg-slate-800">

                                <i class="fa-solid fa-bars"></i>

                            </button>

                            <div>

                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                                    Profil Saya
                                </h1>

                                <p class="text-sm text-slate-500">
                                    Kelola informasi profil akun Anda
                                </p>

                            </div>

                        </div>

                        {{-- KANAN --}}
                        <div class="hidden sm:flex items-center gap-3">

                            <div class="w-10 h-10 rounded-full
                                        bg-blue-100 text-blue-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-user"></i>

                            </div>

                        </div>

                    </div>

                </div>

            </header>


            {{-- CONTENT --}}
            <main class="p-4 sm:p-6 lg:p-8">

                {{-- WELCOME --}}
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600
                            rounded-2xl shadow-lg
                            p-6 sm:p-8 text-white mb-6">

                    <div class="flex flex-col md:flex-row
                                md:items-center md:justify-between gap-6">

                        <div>

                            <p class="text-blue-100 text-sm mb-1">
                                Profil Guru
                            </p>

                            <h2 class="text-2xl sm:text-3xl font-bold">
                                {{ $teacher->name }}
                            </h2>

                            <p class="text-blue-100 mt-2 max-w-2xl">
                                Kelola informasi pribadi dan informasi akun
                                yang digunakan pada sistem SIMOGU.
                            </p>

                        </div>

                        {{-- FOTO PROFIL --}}
                        <div class="flex-shrink-0">

                            @if ($teacher->photo)
                                <img
                                    src="{{ asset('storage/' . $teacher->photo) }}"
                                    alt="Foto Profil"
                                    class="w-20 h-20 rounded-2xl
                                           object-cover
                                           border-2 border-white/40
                                           shadow-lg">
                            @else
                                <div class="w-20 h-20 rounded-2xl
                                            bg-white/20
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-user text-3xl"></i>

                                </div>
                            @endif

                        </div>

                    </div>

                </div>


                {{-- PESAN SUKSES --}}
                @if (session('success'))

                    <div class="mb-6 p-4 rounded-xl
                                bg-emerald-50
                                border border-emerald-200
                                text-emerald-700">

                        <div class="flex items-center gap-3">

                            <i class="fa-solid fa-circle-check"></i>

                            <p class="text-sm font-medium">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>

                @endif


                {{-- ERROR VALIDASI --}}
                @if ($errors->any())

                    <div class="mb-6 p-4 rounded-xl
                                bg-red-50
                                border border-red-200
                                text-red-700">

                        <div class="flex items-start gap-3">

                            <i class="fa-solid fa-circle-exclamation mt-0.5"></i>

                            <div>

                                <p class="font-semibold mb-2">
                                    Terjadi kesalahan:
                                </p>

                                <ul class="list-disc list-inside text-sm">

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


                {{-- INFORMASI PROFIL --}}
                <div class="bg-white rounded-2xl shadow-sm
                            border border-slate-200 overflow-hidden">

                    {{-- HEADER CARD --}}
                    <div class="px-5 sm:px-6 py-5
                                border-b border-slate-200">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-xl
                                        bg-blue-100 text-blue-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-user-pen"></i>

                            </div>

                            <div>

                                <h3 class="text-lg font-bold text-slate-800">
                                    Informasi Profil
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Perbarui informasi pribadi Anda.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- FORM --}}
                    <form
                        method="POST"
                        action="{{ route('guru.profile.update') }}"
                        enctype="multipart/form-data"
                        class="p-5 sm:p-6">

                        @csrf
                        @method('PATCH')


                        {{-- FOTO --}}
                        <div class="mb-6">

                            <label
                                for="photo"
                                class="block text-sm font-semibold text-slate-700 mb-2">

                                Foto Profil

                            </label>

                            <div class="flex flex-col sm:flex-row
                                        items-start sm:items-center gap-4">

                                {{-- FOTO SAAT INI --}}
                                <div class="flex-shrink-0">

                                    @if ($teacher->photo)

                                        <img
                                            src="{{ asset('storage/' . $teacher->photo) }}"
                                            alt="Foto Profil"
                                            class="w-20 h-20 rounded-xl
                                                   object-cover
                                                   border border-slate-200">

                                    @else

                                        <div class="w-20 h-20 rounded-xl
                                                    bg-slate-100
                                                    text-slate-400
                                                    flex items-center justify-center
                                                    border border-slate-200">

                                            <i class="fa-solid fa-user text-2xl"></i>

                                        </div>

                                    @endif

                                </div>

                                <div class="flex-1 w-full">

                                    <input
                                        id="photo"
                                        type="file"
                                        name="photo"
                                        accept=".jpg,.jpeg,.png,.webp"
                                        class="w-full rounded-xl
                                               border border-slate-300
                                               px-4 py-3
                                               text-sm
                                               file:mr-4
                                               file:rounded-lg
                                               file:border-0
                                               file:bg-blue-50
                                               file:px-4
                                               file:py-2
                                               file:text-sm
                                               file:font-semibold
                                               file:text-blue-700
                                               hover:file:bg-blue-100">

                                    <p class="mt-2 text-xs text-slate-500">
                                        Format JPG, JPEG, PNG, atau WEBP.
                                        Maksimal 2 MB.
                                    </p>

                                </div>

                            </div>

                            @error('photo')
                                <p class="mt-2 text-sm text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- DATA PRIBADI --}}
                        <div class="mb-6">

                            <div class="flex items-center gap-2 mb-4">

                                <div class="w-8 h-8 rounded-lg
                                            bg-blue-50 text-blue-600
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-id-card text-sm"></i>

                                </div>

                                <h4 class="font-bold text-slate-800">
                                    Data Pribadi
                                </h4>

                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- NAMA --}}
                                <div>

                                    <label
                                        for="name"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Nama Lengkap

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-user"></i>

                                        </span>

                                        <input
                                            id="name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name', $teacher->name) }}"
                                            required
                                            autocomplete="name"
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                    </div>

                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">
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

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-id-badge"></i>

                                        </span>

                                        <input
                                            id="nip"
                                            type="text"
                                            name="nip"
                                            value="{{ old('nip', $teacher->nip) }}"
                                            required
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                    </div>

                                    @error('nip')
                                        <p class="mt-2 text-sm text-red-600">
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

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-address-card"></i>

                                        </span>

                                        <input
                                            id="nik"
                                            type="text"
                                            name="nik"
                                            value="{{ old('nik', $teacher->nik) }}"
                                            required
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                    </div>

                                    @error('nik')
                                        <p class="mt-2 text-sm text-red-600">
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

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400
                                                     pointer-events-none">

                                            <i class="fa-solid fa-venus-mars"></i>

                                        </span>

                                        <select
                                            id="gender"
                                            name="gender"
                                            required
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   bg-white
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                            <option value="">
                                                Pilih Jenis Kelamin
                                            </option>

                                            <option
                                                value="Laki-laki"
                                                {{ old('gender', $teacher->gender) === 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki
                                            </option>

                                            <option
                                                value="Perempuan"
                                                {{ old('gender', $teacher->gender) === 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>

                                        </select>

                                    </div>

                                    @error('gender')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- TELEPON --}}
                                <div>

                                    <label
                                        for="phone"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Nomor Telepon

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-phone"></i>

                                        </span>

                                        <input
                                            id="phone"
                                            type="text"
                                            name="phone"
                                            value="{{ old('phone', $teacher->phone) }}"
                                            autocomplete="tel"
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                    </div>

                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- EMAIL --}}
                                <div>

                                    <label
                                        for="email"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Email

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-envelope"></i>

                                        </span>

                                        <input
                                            id="email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email', $teacher->user->email) }}"
                                            required
                                            autocomplete="username"
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                    </div>

                                    @error('email')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- MATA PELAJARAN --}}
                                <div class="md:col-span-2">

                                    <label
                                        for="subject"
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Mata Pelajaran

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-book-open"></i>

                                        </span>

                                        <input
                                            id="subject"
                                            type="text"
                                            name="subject"
                                            value="{{ old('subject', $teacher->subject) }}"
                                            required
                                            class="w-full rounded-xl
                                                   border border-slate-300
                                                   pl-11 pr-4 py-3
                                                   focus:border-blue-500
                                                   focus:ring-blue-500">

                                    </div>

                                    @error('subject')
                                        <p class="mt-2 text-sm text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                            </div>

                        </div>


                        {{-- INFORMASI SEKOLAH --}}
                        <div class="mb-6">

                            <div class="flex items-center gap-2 mb-4">

                                <div class="w-8 h-8 rounded-lg
                                            bg-indigo-50 text-indigo-600
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-school text-sm"></i>

                                </div>

                                <h4 class="font-bold text-slate-800">
                                    Informasi Sekolah
                                </h4>

                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- NAMA SEKOLAH --}}
                                <div>

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Nama Sekolah

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-school"></i>

                                        </span>

                                        <input
                                            type="text"
                                            value="{{ $teacher->school?->name ?? '-' }}"
                                            readonly
                                            class="w-full rounded-xl
                                                   border border-slate-200
                                                   bg-slate-50
                                                   text-slate-600
                                                   pl-11 pr-4 py-3
                                                   cursor-not-allowed">

                                    </div>

                                </div>


                                {{-- NPSN --}}
                                <div>

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        NPSN

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-hashtag"></i>

                                        </span>

                                        <input
                                            type="text"
                                            value="{{ $teacher->school?->npsn ?? '-' }}"
                                            readonly
                                            class="w-full rounded-xl
                                                   border border-slate-200
                                                   bg-slate-50
                                                   text-slate-600
                                                   pl-11 pr-4 py-3
                                                   cursor-not-allowed">

                                    </div>

                                </div>


                                {{-- ALAMAT --}}
                                <div class="md:col-span-2">

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Alamat Sekolah

                                    </label>

                                    <div class="relative">

                                        <span class="absolute top-3 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-location-dot"></i>

                                        </span>

                                        <textarea
                                            readonly
                                            rows="3"
                                            class="w-full rounded-xl
                                                   border border-slate-200
                                                   bg-slate-50
                                                   text-slate-600
                                                   pl-11 pr-4 py-3
                                                   cursor-not-allowed
                                                   resize-none">{{ $teacher->school?->address ?? '-' }}</textarea>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- STATUS --}}
                        <div class="mb-6">

                            <div class="flex items-center gap-2 mb-4">

                                <div class="w-8 h-8 rounded-lg
                                            bg-emerald-50 text-emerald-600
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-circle-info text-sm"></i>

                                </div>

                                <h4 class="font-bold text-slate-800">
                                    Status Kepegawaian
                                </h4>

                            </div>


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                {{-- STATUS --}}
                                <div>

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Status

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-toggle-on"></i>

                                        </span>

                                        <input
                                            type="text"
                                            value="{{ ucfirst($teacher->status ?? '-') }}"
                                            readonly
                                            class="w-full rounded-xl
                                                   border border-slate-200
                                                   bg-slate-50
                                                   text-slate-600
                                                   pl-11 pr-4 py-3
                                                   cursor-not-allowed">

                                    </div>

                                </div>


                                {{-- STATUS KEPEGAWAIAN --}}
                                <div>

                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">

                                        Status Kepegawaian

                                    </label>

                                    <div class="relative">

                                        <span class="absolute inset-y-0 left-0
                                                     flex items-center pl-4
                                                     text-slate-400">

                                            <i class="fa-solid fa-briefcase"></i>

                                        </span>

                                        <input
                                            type="text"
                                            value="{{ $teacher->employment_status ?? '-' }}"
                                            readonly
                                            class="w-full rounded-xl
                                                   border border-slate-200
                                                   bg-slate-50
                                                   text-slate-600
                                                   pl-11 pr-4 py-3
                                                   cursor-not-allowed">

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- TOMBOL --}}
                        <div class="flex flex-col sm:flex-row
                                    items-stretch sm:items-center
                                    justify-end gap-3
                                    pt-5 border-t border-slate-200">

                            <a
                                href="{{ route('guru.dashboard') }}"
                                class="inline-flex items-center justify-center gap-2
                                       px-5 py-2.5 rounded-xl
                                       bg-slate-100 text-slate-700
                                       font-semibold
                                       hover:bg-slate-200 transition">

                                <i class="fa-solid fa-arrow-left"></i>

                                Kembali

                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2
                                       px-5 py-2.5 rounded-xl
                                       bg-blue-600 text-white
                                       font-semibold
                                       hover:bg-blue-700 transition">

                                <i class="fa-solid fa-floppy-disk"></i>

                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>

            </main>

        </div>

    </div>


    {{-- SIDEBAR SCRIPT --}}
    <script>

        const sidebar = document.getElementById('guru-sidebar');
        const overlay = document.getElementById('guru-sidebar-overlay');
        const toggle = document.getElementById('guruSidebarToggle');

        function openSidebar() {

            if (!sidebar || !overlay) return;

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');

        }

        function closeSidebar() {

            if (!sidebar || !overlay) return;

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');

        }

        toggle?.addEventListener('click', function () {

            if (!sidebar) return;

            if (sidebar.classList.contains('-translate-x-full')) {

                openSidebar();

            } else {

                closeSidebar();

            }

        });

        overlay?.addEventListener('click', closeSidebar);

    </script>

</body>

</html>