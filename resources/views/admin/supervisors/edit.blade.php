<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Pengawas - SIMOGU</title>

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

    <main class="lg:ml-64 min-h-screen w-auto">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="w-full px-4 sm:px-6 lg:px-8 py-5">

                <div
                    class="flex flex-col
                           sm:flex-row
                           sm:items-center
                           sm:justify-between
                           gap-4"
                >


                    {{-- TITLE --}}

                    <div class="flex items-start gap-3 min-w-0">

                        {{-- Ruang hamburger mobile --}}

                        <div class="w-10 shrink-0 lg:hidden"></div>


                        <div class="min-w-0">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-2 h-8
                                           bg-purple-600
                                           rounded-full
                                           shrink-0"
                                ></div>


                                <div class="min-w-0">

                                    <h1
                                        class="text-xl
                                               sm:text-2xl
                                               lg:text-3xl
                                               font-bold
                                               text-slate-800
                                               truncate"
                                    >

                                        Edit Pengawas

                                    </h1>


                                    <p
                                        class="text-sm
                                               sm:text-base
                                               text-slate-500
                                               mt-1"
                                    >

                                        Perbarui data pengawas dan akun login.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- USER --}}

                    <div
                        class="text-left
                               sm:text-right
                               ml-12
                               sm:ml-0
                               shrink-0"
                    >

                        @auth

                            <p
                                class="font-semibold
                                       text-slate-800"
                            >

                                {{ auth()->user()->name }}

                            </p>


                            <div
                                class="inline-flex
                                       items-center
                                       gap-1.5
                                       mt-1"
                            >

                                <span
                                    class="w-2 h-2
                                           rounded-full
                                           bg-emerald-500"
                                ></span>


                                <p
                                    class="text-sm
                                           text-emerald-600"
                                >

                                    Administrator

                                </p>

                            </div>

                        @endauth

                    </div>

                </div>

            </div>

        </header>


        {{-- ===================================================== --}}
        {{-- CONTENT --}}
        {{-- ===================================================== --}}

        <section
            class="w-full
                   p-4
                   sm:p-6
                   lg:p-8"
        >


            {{-- ================================================= --}}
            {{-- BREADCRUMB / BACK --}}
            {{-- ================================================= --}}

            <div class="mb-6">

                <a
                    href="{{ route('admin.supervisors.index') }}"
                    class="inline-flex
                           items-center
                           gap-2
                           text-sm
                           font-semibold
                           text-slate-600
                           hover:text-purple-600
                           transition"
                >

                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />

                    </svg>

                    Kembali ke Data Pengawas

                </a>

            </div>


            {{-- ================================================= --}}
            {{-- ERROR MESSAGE --}}
            {{-- ================================================= --}}

            @if ($errors->any())

                <div
                    class="mb-6
                           flex
                           items-start
                           gap-3
                           rounded-2xl
                           bg-red-50
                           border
                           border-red-200
                           text-red-800
                           px-5
                           py-4
                           shadow-sm"
                >

                    <div
                        class="w-9 h-9
                               rounded-xl
                               bg-red-100
                               flex
                               items-center
                               justify-center
                               shrink-0"
                    >

                        <svg
                            class="w-5 h-5 text-red-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />

                        </svg>

                    </div>


                    <div>

                        <p class="font-semibold">

                            Terdapat kesalahan pada data.

                        </p>


                        <ul
                            class="mt-2
                                   list-disc
                                   list-inside
                                   text-sm
                                   text-red-700
                                   space-y-1"
                        >

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- FORM --}}
            {{-- ================================================= --}}

            <form
                method="POST"
                action="{{ route('admin.supervisors.update', $supervisor) }}"
                enctype="multipart/form-data"
            >

                @csrf

                @method('PUT')


                {{-- ================================================= --}}
                {{-- GRID UTAMA --}}
                {{-- ================================================= --}}

                <div
                    class="grid
                           grid-cols-1
                           xl:grid-cols-3
                           gap-6"
                >


                    {{-- ================================================= --}}
                    {{-- FOTO --}}
                    {{-- ================================================= --}}

                    <div
                        class="bg-white
                               rounded-2xl
                               border
                               border-slate-200
                               shadow-sm
                               overflow-hidden"
                    >

                        <div
                            class="px-5
                                   sm:px-6
                                   py-5
                                   border-b
                                   border-slate-200"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10
                                           rounded-xl
                                           bg-purple-100
                                           text-purple-600
                                           flex
                                           items-center
                                           justify-center
                                           shrink-0"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15.75 7.5a3.75 3.75 0 11-7.5 0zM4.5 21a7.5 7.5 0 0115 0"
                                        />

                                    </svg>

                                </div>


                                <div>

                                    <h2
                                        class="font-bold
                                               text-slate-800"
                                    >

                                        Foto Pengawas

                                    </h2>


                                    <p
                                        class="text-xs
                                               text-slate-500
                                               mt-1"
                                    >

                                        Ganti foto profil pengawas.

                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="p-5 sm:p-6">

                            <div
                                class="flex
                                       flex-col
                                       items-center"
                            >


                                {{-- PREVIEW FOTO --}}

                                <div
                                    id="photoPreview"
                                    class="w-36 h-36
                                           sm:w-40
                                           sm:h-40
                                           rounded-2xl
                                           bg-slate-50
                                           border-2
                                           border-dashed
                                           border-slate-300
                                           flex
                                           items-center
                                           justify-center
                                           overflow-hidden"
                                >

                                    @if ($supervisor->photo)

                                        <img
                                            src="{{ asset('storage/' . $supervisor->photo) }}"
                                            class="w-full h-full object-cover"
                                            alt="{{ $supervisor->name }}"
                                            id="currentPhoto"
                                        >

                                    @else

                                        <svg
                                            id="photoPlaceholder"
                                            class="w-16 h-16 text-slate-300"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.5"
                                                d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 21a7.5 7.5 0 0115 0"
                                            />

                                        </svg>

                                    @endif

                                </div>


                                {{-- INPUT FOTO --}}

                                <label
                                    for="photo"
                                    class="mt-5
                                           inline-flex
                                           items-center
                                           justify-center
                                           gap-2
                                           cursor-pointer
                                           bg-purple-600
                                           hover:bg-purple-700
                                           text-white
                                           px-5
                                           py-2.5
                                           rounded-xl
                                           font-semibold
                                           shadow-sm
                                           hover:shadow-md
                                           transition"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />

                                    </svg>

                                    Ganti Foto


                                    <input
                                        type="file"
                                        name="photo"
                                        id="photo"
                                        accept="image/jpeg,image/png,image/webp"
                                        class="hidden"
                                    >

                                </label>


                                <p
                                    class="text-xs
                                           text-slate-400
                                           mt-3
                                           text-center
                                           leading-relaxed"
                                >

                                    Pilih foto baru jika ingin mengganti.
                                    <br>
                                    JPG, JPEG, PNG atau WEBP
                                    <br>
                                    Maksimal 2 MB

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- DATA PENGAWAS --}}
                    {{-- ================================================= --}}

                    <div
                        class="xl:col-span-2
                               bg-white
                               rounded-2xl
                               border
                               border-slate-200
                               shadow-sm
                               overflow-hidden"
                    >


                        {{-- HEADER --}}

                        <div
                            class="px-5
                                   sm:px-6
                                   py-5
                                   border-b
                                   border-slate-200"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10
                                           rounded-xl
                                           bg-purple-100
                                           text-purple-600
                                           flex
                                           items-center
                                           justify-center
                                           shrink-0"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />

                                    </svg>

                                </div>


                                <div>

                                    <h2
                                        class="font-bold
                                               text-slate-800"
                                    >

                                        Data Pengawas

                                    </h2>


                                    <p
                                        class="text-sm
                                               text-slate-500
                                               mt-1"
                                    >

                                        Perbarui informasi pengawas sekolah.

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- FORM DATA --}}

                        <div
                            class="p-5
                                   sm:p-6"
                        >

                            <div
                                class="grid
                                       grid-cols-1
                                       md:grid-cols-2
                                       gap-5"
                            >


                                {{-- SEKOLAH --}}

                                <div class="md:col-span-2">

                                    <label
                                        for="school_id"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Sekolah
                                        <span class="text-red-500">*</span>

                                    </label>


                                    <select
                                        id="school_id"
                                        name="school_id"
                                        required
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-purple-500
                                               focus:ring-purple-500"
                                    >

                                        <option value="">
                                            -- Pilih Sekolah --
                                        </option>


                                        @foreach ($schools as $school)

                                            <option
                                                value="{{ $school->id }}"
                                                {{ old('school_id', $supervisor->school_id) == $school->id ? 'selected' : '' }}
                                            >

                                                {{ $school->name }}

                                            </option>

                                        @endforeach

                                    </select>


                                    @error('school_id')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- NIP --}}

                                <div>

                                    <label
                                        for="nip"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        NIP
                                        <span class="text-red-500">*</span>

                                    </label>


                                    <input
                                        type="text"
                                        id="nip"
                                        name="nip"
                                        value="{{ old('nip', $supervisor->nip) }}"
                                        required
                                        maxlength="50"
                                        placeholder="Masukkan NIP"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-purple-500
                                               focus:ring-purple-500"
                                    >


                                    @error('nip')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- NAMA --}}

                                <div>

                                    <label
                                        for="name"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Nama Lengkap
                                        <span class="text-red-500">*</span>

                                    </label>


                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', $supervisor->name) }}"
                                        required
                                        maxlength="255"
                                        placeholder="Nama lengkap pengawas"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-purple-500
                                               focus:ring-purple-500"
                                    >


                                    @error('name')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- TELEPON --}}

                                <div>

                                    <label
                                        for="phone"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        No. HP

                                    </label>


                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone', $supervisor->phone) }}"
                                        maxlength="30"
                                        placeholder="08xxxxxxxxxx"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-purple-500
                                               focus:ring-purple-500"
                                    >


                                    @error('phone')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- STATUS --}}

                                <div>

                                    <label
                                        for="status"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Status
                                        <span class="text-red-500">*</span>

                                    </label>


                                    <select
                                        id="status"
                                        name="status"
                                        required
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-purple-500
                                               focus:ring-purple-500"
                                    >

                                        <option
                                            value="aktif"
                                            {{ old('status', $supervisor->status) === 'aktif' ? 'selected' : '' }}
                                        >

                                            Aktif

                                        </option>


                                        <option
                                            value="nonaktif"
                                            {{ old('status', $supervisor->status) === 'nonaktif' ? 'selected' : '' }}
                                        >

                                            Nonaktif

                                        </option>

                                    </select>


                                    @error('status')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- AKUN LOGIN --}}
                    {{-- ================================================= --}}

                    <div
                        class="xl:col-span-3
                               bg-white
                               rounded-2xl
                               border
                               border-slate-200
                               shadow-sm
                               overflow-hidden"
                    >


                        {{-- HEADER AKUN --}}

                        <div
                            class="px-5
                                   sm:px-6
                                   py-5
                                   border-b
                                   border-slate-200"
                        >

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10
                                           rounded-xl
                                           bg-blue-100
                                           text-blue-600
                                           flex
                                           items-center
                                           justify-center
                                           shrink-0"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 7a3 3 0 11-6 0 3 3 0 016 0zM5 21a7 7 0 0114 0M17 11l2 2m0 0l2-2m-2 2v4"
                                        />

                                    </svg>

                                </div>


                                <div>

                                    <h2
                                        class="font-bold
                                               text-slate-800"
                                    >

                                        Akun Login Pengawas

                                    </h2>


                                    <p
                                        class="text-sm
                                               text-slate-500
                                               mt-1"
                                    >

                                        Perbarui email atau password login pengawas.

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- FORM AKUN --}}

                        <div
                            class="p-5
                                   sm:p-6"
                        >

                            <div
                                class="grid
                                       grid-cols-1
                                       md:grid-cols-3
                                       gap-5"
                            >


                                {{-- EMAIL --}}

                                <div>

                                    <label
                                        for="email"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Email Login
                                        <span class="text-red-500">*</span>

                                    </label>


                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email', optional($supervisor->user)->email ?? $supervisor->email) }}"
                                        required
                                        maxlength="255"
                                        placeholder="pengawas@email.com"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >


                                    @error('email')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- PASSWORD BARU --}}

                                <div>

                                    <label
                                        for="password"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Password Baru

                                    </label>


                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        minlength="8"
                                        placeholder="Kosongkan jika tidak diubah"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >


                                    @error('password')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>


                                {{-- KONFIRMASI PASSWORD --}}

                                <div>

                                    <label
                                        for="password_confirmation"
                                        class="block
                                               text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Konfirmasi Password Baru

                                    </label>


                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        minlength="8"
                                        placeholder="Ulangi password baru"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >


                                    @error('password_confirmation')

                                        <p class="text-red-600 text-sm mt-1">
                                            {{ $message }}
                                        </p>

                                    @enderror

                                </div>

                            </div>


                            {{-- CATATAN PASSWORD --}}

                            <div
                                class="mt-5
                                       bg-blue-50
                                       border
                                       border-blue-200
                                       rounded-xl
                                       p-4"
                            >

                                <div class="flex items-start gap-3">

                                    <svg
                                        class="w-5 h-5
                                               text-blue-600
                                               mt-0.5
                                               shrink-0"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"
                                        />

                                    </svg>


                                    <div
                                        class="text-sm
                                               text-blue-700"
                                    >

                                        <p>

                                            <strong>Catatan:</strong>

                                        </p>

                                        <ul
                                            class="mt-1
                                                   list-disc
                                                   list-inside
                                                   space-y-1"
                                        >

                                            <li>
                                                Kosongkan password jika tidak ingin mengubah password lama.
                                            </li>

                                            <li>
                                                Jika ingin mengganti password, isi Password Baru dan Konfirmasi Password Baru.
                                            </li>

                                            <li>
                                                Password minimal 8 karakter.
                                            </li>

                                        </ul>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>


                {{-- ================================================= --}}
                {{-- BUTTON --}}
                {{-- ================================================= --}}

                <div
                    class="mt-6
                           bg-white
                           rounded-2xl
                           border
                           border-slate-200
                           shadow-sm
                           p-5
                           sm:p-6"
                >

                    <div
                        class="flex
                               flex-col-reverse
                               sm:flex-row
                               sm:justify-end
                               gap-3"
                    >


                        {{-- BATAL --}}

                        <a
                            href="{{ route('admin.supervisors.show', $supervisor) }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-6
                                   py-3
                                   rounded-xl
                                   bg-slate-100
                                   hover:bg-slate-200
                                   text-slate-700
                                   font-semibold
                                   transition"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                />

                            </svg>

                            Batal

                        </a>


                        {{-- SIMPAN --}}

                        <button
                            type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-6
                                   py-3
                                   rounded-xl
                                   bg-purple-600
                                   hover:bg-purple-700
                                   text-white
                                   font-semibold
                                   shadow-sm
                                   hover:shadow-md
                                   transition"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
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


        </section>


    </main>


    {{-- ========================================================= --}}
    {{-- PREVIEW FOTO --}}
    {{-- ========================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const photoInput =
                document.getElementById('photo');

            const photoPreview =
                document.getElementById('photoPreview');


            if (!photoInput || !photoPreview) {
                return;
            }


            photoInput.addEventListener('change', function (event) {

                const file =
                    event.target.files[0];


                if (!file) {
                    return;
                }


                // Validasi tipe file

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];


                if (!allowedTypes.includes(file.type)) {

                    alert(
                        'File yang dipilih harus JPG, JPEG, PNG, atau WEBP.'
                    );

                    photoInput.value = '';

                    return;

                }


                // Validasi ukuran 2 MB

                if (file.size > 2 * 1024 * 1024) {

                    alert(
                        'Ukuran foto maksimal 2 MB.'
                    );

                    photoInput.value = '';

                    return;

                }


                const reader =
                    new FileReader();


                reader.onload = function (e) {

                    photoPreview.innerHTML = `

                        <img
                            src="${e.target.result}"
                            class="w-full h-full object-cover"
                            alt="Preview Foto Pengawas"
                        >

                    `;

                };


                reader.readAsDataURL(file);

            });

        });

    </script>


</body>

</html>