<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Guru - SIMOGU</title>

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

            <header class="sticky top-0 z-30 bg-white/95 backdrop-blur border-b border-slate-200 shadow-sm">

                <div class="px-4 sm:px-6 lg:px-8 py-4">

                    <div class="flex items-center justify-between gap-4">

                        {{-- Judul --}}

                        <div class="flex items-center gap-3 min-w-0">

                            <div class="w-1.5 h-10 bg-blue-600 rounded-full shrink-0"></div>

                            <div class="min-w-0">

                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800 truncate">
                                    Edit Guru
                                </h1>

                                <p class="text-sm text-slate-500 mt-1 hidden sm:block">
                                    Perbarui informasi guru dan akun login.
                                </p>

                            </div>

                        </div>


                        {{-- User --}}

                        <div class="hidden sm:block text-right shrink-0">

                            <p class="font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>

                            <div class="flex items-center justify-end gap-1 mt-1">

                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                <span class="text-xs text-emerald-600 font-medium">
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

            <section class="p-4 sm:p-6 lg:p-8">

                <div class="w-full">


                    {{-- ================================================= --}}
                    {{-- TOP ACTION --}}
                    {{-- ================================================= --}}

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                        <div>

                            <p class="text-sm text-slate-500">
                                Kelola informasi lengkap:
                            </p>

                            <div class="flex flex-wrap items-center gap-2 mt-2">

                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold">
                                    Data Pribadi
                                </span>

                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                    Data Kepegawaian
                                </span>

                                <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-700 text-xs font-semibold">
                                    Akun Login
                                </span>

                            </div>

                        </div>
                        <a
                            href="{{ route('admin.teachers.show', $teacher) }}"
                            class="inline-flex items-center justify-center gap-2
                            px-5 py-2.5
                            rounded-xl
                            bg-white
                            border border-slate-200
                            text-slate-700
                            font-semibold
                            shadow-sm
                            hover:bg-slate-50
                            hover:border-slate-300
                            transition">

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />

                            </svg>

                            Kembali

                        </a>

                    </div>


                    {{-- ================================================= --}}
                    {{-- ERROR --}}
                    {{-- ================================================= --}}

                    @if ($errors->any())

                        <div class="mb-6 rounded-2xl
                            bg-red-50
                            border border-red-200
                            p-5">

                            <div class="flex items-start gap-3">

                                <div class="w-10 h-10 shrink-0
                                    rounded-xl
                                    bg-red-100
                                    flex items-center justify-center">

                                    <svg
                                        class="w-5 h-5 text-red-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z" />

                                    </svg>

                                </div>

                                <div>

                                    <p class="font-bold text-red-700">
                                        Terdapat kesalahan pada form
                                    </p>

                                    <ul class="list-disc list-inside
                                        text-sm text-red-600
                                        mt-2 space-y-1">

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

                    <div class="bg-white
                        rounded-3xl
                        border border-slate-200
                        shadow-sm
                        overflow-hidden">


                        {{-- ================================================= --}}
                        {{-- CARD HEADER --}}
                        {{-- ================================================= --}}

                        <div class="px-5 sm:px-7 py-5
                            border-b border-slate-200
                            bg-gradient-to-r
                            from-blue-50
                            via-white
                            to-white">

                            <div class="flex items-center gap-4">

                                <div class="w-12 h-12 shrink-0
                                    rounded-2xl
                                    bg-blue-100
                                    flex items-center justify-center">

                                    <svg
                                        class="w-6 h-6 text-blue-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                                    </svg>

                                </div>

                                <div>

                                    <h2 class="text-lg font-bold text-slate-800">
                                        Informasi Guru
                                    </h2>

                                    <p class="text-sm text-slate-500">
                                        {{ $teacher->name }}
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- FORM --}}
                        {{-- ================================================= --}}

                        <form
                            method="POST"
                            action="{{ route('admin.teachers.update', $teacher) }}"
                            enctype="multipart/form-data"
                            class="p-5 sm:p-7">

                            @csrf

                            @method('PUT')


                            {{-- ================================================= --}}
                            {{-- FOTO --}}
                            {{-- ================================================= --}}

                            <div class="mb-8">

                                <div class="flex items-center gap-2 mb-4">

                                    <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>

                                    <h3 class="font-bold text-slate-800">
                                        Foto Guru
                                    </h3>

                                </div>


                                <div class="rounded-2xl
                                    border border-slate-200
                                    bg-slate-50
                                    p-4 sm:p-5">

                                    <div class="flex flex-col sm:flex-row
                                        items-start sm:items-center
                                        gap-5">

                                        {{-- FOTO --}}

                                        <div class="shrink-0">

                                            @if($teacher->photo)

                                                <img
                                                    src="{{ asset('storage/' . $teacher->photo) }}"
                                                    alt="{{ $teacher->name }}"
                                                    class="w-24 h-24
                                                    rounded-2xl
                                                    object-cover
                                                    border-4
                                                    border-white
                                                    shadow-md">

                                            @else

                                                <div class="w-24 h-24
                                                    rounded-2xl
                                                    bg-slate-200
                                                    flex items-center justify-center
                                                    border-4
                                                    border-white
                                                    shadow-md">

                                                    <svg
                                                        class="w-9 h-9 text-slate-400"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24">

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                                                    </svg>

                                                </div>

                                            @endif

                                        </div>


                                        {{-- UPLOAD --}}

                                        <div class="flex-1 w-full">

                                            <label
                                                for="photo"
                                                class="block text-sm font-semibold
                                                text-slate-700 mb-2">

                                                Ganti Foto

                                            </label>

                                            <input
                                                id="photo"
                                                type="file"
                                                name="photo"
                                                accept="image/jpeg,image/png,image/webp"
                                                class="block w-full text-sm
                                                text-slate-600

                                                file:mr-4
                                                file:py-2.5
                                                file:px-5
                                                file:rounded-xl
                                                file:border-0
                                                file:bg-blue-100
                                                file:text-blue-700
                                                file:font-semibold

                                                hover:file:bg-blue-200">

                                            <p class="text-xs text-slate-500 mt-2">
                                                JPG, PNG atau WEBP. Maksimal 2 MB.
                                            </p>

                                            @error('photo')

                                                <p class="text-xs text-red-600 mt-1">
                                                    {{ $message }}
                                                </p>

                                            @enderror

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- DATA GURU --}}
                            {{-- ================================================= --}}

                            <div class="mb-8">

                                <div class="flex items-center gap-2 mb-5">

                                    <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>

                                    <div>

                                        <h3 class="font-bold text-slate-800">
                                            Data Guru
                                        </h3>

                                        <p class="text-xs text-slate-500">
                                            Informasi pribadi dan kepegawaian
                                        </p>

                                    </div>

                                </div>


                                {{-- ================================================= --}}
                                {{-- 3 KOLOM DESKTOP --}}
                                {{-- ================================================= --}}

                                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">


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
                                            class="w-full rounded-xl
                                            border-slate-300
                                            bg-white
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                            <option value="">
                                                -- Pilih Sekolah --
                                            </option>

                                            @foreach($schools as $school)

                                                <option
                                                    value="{{ $school->id }}"
                                                    {{ old('school_id', $teacher->school_id) == $school->id ? 'selected' : '' }}>

                                                    {{ $school->name }}

                                                </option>

                                            @endforeach

                                        </select>

                                        @error('school_id')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            id="name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name', $teacher->name) }}"
                                            required
                                            placeholder="Nama lengkap guru"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                        @error('name')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            id="nip"
                                            type="text"
                                            name="nip"
                                            value="{{ old('nip', $teacher->nip) }}"
                                            placeholder="Masukkan NIP"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                        @error('nip')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            id="nik"
                                            type="text"
                                            name="nik"
                                            value="{{ old('nik', $teacher->nik) }}"
                                            placeholder="Masukkan NIK"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                        @error('nik')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            class="w-full rounded-xl
                                            border-slate-300
                                            bg-white
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                            <option value="">
                                                -- Pilih Jenis Kelamin --
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

                                        @error('gender')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            id="subject"
                                            type="text"
                                            name="subject"
                                            value="{{ old('subject', $teacher->subject) }}"
                                            placeholder="Contoh: Matematika"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                        @error('subject')

                                            <p class="text-xs text-red-600 mt-1">
                                                {{ $message }}
                                            </p>

                                        @enderror

                                    </div>


                                    {{-- STATUS KEPEGAWAIAN --}}

                                    <div>

                                        <label
                                            for="employment_status"
                                            class="block text-sm font-semibold text-slate-700 mb-2">

                                            Status Kepegawaian

                                        </label>

                                        <select
                                            id="employment_status"
                                            name="employment_status"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            bg-white
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                            <option value="">
                                                -- Pilih Status --
                                            </option>

                                            @foreach(['PNS', 'PPPK', 'Honorer', 'Non-ASN'] as $status)

                                                <option
                                                    value="{{ $status }}"
                                                    {{ old('employment_status', $teacher->employment_status) === $status ? 'selected' : '' }}>

                                                    {{ $status }}

                                                </option>

                                            @endforeach

                                        </select>

                                        @error('employment_status')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            id="phone"
                                            type="text"
                                            name="phone"
                                            value="{{ old('phone', $teacher->phone) }}"
                                            placeholder="08xxxxxxxxxx"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                        @error('phone')

                                            <p class="text-xs text-red-600 mt-1">
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
                                            <span class="text-red-500">*</span>

                                        </label>

                                        <input
                                            id="email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email', $teacher->email) }}"
                                            required
                                            placeholder="nama@email.com"
                                            class="w-full rounded-xl
                                            border-slate-300
                                            px-4 py-3
                                            focus:border-blue-500
                                            focus:ring-blue-500">

                                        @error('email')

                                            <p class="text-xs text-red-600 mt-1">
                                                {{ $message }}
                                            </p>

                                        @enderror

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PASSWORD --}}
                            {{-- ================================================= --}}

                            <div class="mb-8">

                                <div class="rounded-2xl
                                    border border-amber-200
                                    bg-gradient-to-r
                                    from-amber-50
                                    to-orange-50
                                    p-5">


                                    <div class="flex items-center gap-3 mb-5">

                                        <div class="w-11 h-11 rounded-xl
                                            bg-amber-100
                                            flex items-center justify-center">

                                            <svg
                                                class="w-5 h-5 text-amber-600"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />

                                            </svg>

                                        </div>

                                        <div>

                                            <h3 class="font-bold text-slate-800">
                                                Keamanan Akun
                                            </h3>

                                            <p class="text-sm text-slate-600">
                                                Ubah password login jika diperlukan.
                                            </p>

                                        </div>

                                    </div>


                                    {{-- 3 KOLOM --}}

                                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">


                                        {{-- PASSWORD --}}

                                        <div>

                                            <label
                                                for="password"
                                                class="block text-sm font-semibold text-slate-700 mb-2">

                                                Password Baru

                                            </label>

                                            <input
                                                id="password"
                                                type="password"
                                                name="password"
                                                autocomplete="new-password"
                                                placeholder="Password baru"
                                                class="w-full rounded-xl
                                                border-slate-300
                                                bg-white
                                                px-4 py-3
                                                focus:border-blue-500
                                                focus:ring-blue-500">

                                            @error('password')

                                                <p class="text-xs text-red-600 mt-1">
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

                                            </label>

                                            <input
                                                id="password_confirmation"
                                                type="password"
                                                name="password_confirmation"
                                                autocomplete="new-password"
                                                placeholder="Ulangi password"
                                                class="w-full rounded-xl
                                                border-slate-300
                                                bg-white
                                                px-4 py-3
                                                focus:border-blue-500
                                                focus:ring-blue-500">

                                        </div>


                                        {{-- INFO --}}

                                        <div class="flex items-end">

                                            <div class="w-full rounded-xl
                                                bg-white/80
                                                border border-amber-200
                                                px-4 py-3">

                                                <p class="text-xs font-bold text-amber-700">
                                                    Informasi
                                                </p>

                                                <p class="text-xs text-slate-600 mt-1">
                                                    Kosongkan password jika
                                                    tidak ingin mengubahnya.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- BUTTON --}}
                            {{-- ================================================= --}}

                            <div class="flex flex-col-reverse
                                sm:flex-row
                                justify-end
                                gap-3
                                pt-6
                                border-t border-slate-200">

                                <a
                                    href="{{ route('admin.teachers.show', $teacher) }}"
                                    class="inline-flex items-center
                                    justify-center gap-2
                                    px-6 py-3
                                    rounded-xl
                                    bg-slate-100
                                    text-slate-700
                                    font-semibold
                                    hover:bg-slate-200
                                    transition">

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />

                                    </svg>

                                    Batal

                                </a>


                                <button
                                    type="submit"
                                    class="inline-flex items-center
                                    justify-center gap-2
                                    px-7 py-3
                                    rounded-xl
                                    bg-blue-600
                                    text-white
                                    font-semibold
                                    shadow-sm
                                    hover:bg-blue-700
                                    hover:shadow-md
                                    active:scale-[0.98]
                                    transition">

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7" />

                                    </svg>

                                    Simpan Perubahan

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </section>

        </main>

    </div>

</body>
</html>