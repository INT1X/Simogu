<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Profil Pengawas - SIMOGU</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-slate-100">

    {{-- SIDEBAR --}}
    @include('components.pengawas-sidebar')


    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-6">

                <div class="flex flex-col sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-4">

                    <div>

                        <div class="flex items-center gap-2 mb-2">

                            <div class="w-9 h-9
                                        rounded-xl
                                        bg-blue-100
                                        text-blue-600
                                        flex items-center
                                        justify-center">

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

                            <span class="text-sm
                                         font-semibold
                                         text-blue-600">
                                Pengaturan Akun
                            </span>

                        </div>

                        <h1 class="text-2xl sm:text-3xl
                                   font-bold
                                   text-slate-800">
                            Profil Pengawas
                        </h1>

                        <p class="text-sm
                                  text-slate-500
                                  mt-1">
                            Kelola informasi pribadi dan akun Anda.
                        </p>

                    </div>


                    <div class="flex items-center gap-3">

                        <div class="text-right">

                            <p class="font-semibold text-slate-800">
                                {{ $supervisor->name }}
                            </p>

                            <p class="text-sm text-blue-600">
                                Pengawas
                            </p>

                        </div>

                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-blue-100
                                    text-blue-700
                                    flex items-center
                                    justify-center
                                    font-bold">

                            {{ strtoupper(substr($supervisor->name, 0, 1)) }}

                        </div>

                    </div>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">

            {{-- SUCCESS --}}
            @if(session('success'))

                <div class="mb-6
                            rounded-2xl
                            border border-emerald-200
                            bg-emerald-50
                            px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="w-9 h-9
                                    rounded-xl
                                    bg-emerald-100
                                    text-emerald-600
                                    flex items-center
                                    justify-center">

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

                        </div>

                        <p class="font-semibold text-emerald-700">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- ERROR --}}
            @if($errors->any())

                <div class="mb-6
                            rounded-2xl
                            border border-red-200
                            bg-red-50
                            px-5 py-4">

                    <div class="flex items-start gap-3">

                        <div class="w-9 h-9
                                    rounded-xl
                                    bg-red-100
                                    text-red-600
                                    flex items-center
                                    justify-center
                                    flex-shrink-0">

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
                                    d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.53 20h14.94a2 2 0 001.74-3.14l-7.5-13a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="font-bold text-red-700">
                                Terdapat kesalahan
                            </p>

                            <ul class="mt-2
                                       list-disc
                                       list-inside
                                       text-sm
                                       text-red-600
                                       space-y-1">

                                @foreach($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- PROFILE HEADER --}}
            <div class="bg-white
                        rounded-3xl
                        border border-slate-200
                        shadow-sm
                        overflow-hidden
                        mb-6">

                {{-- COVER --}}
                <div class="h-36
                            bg-gradient-to-r
                            from-blue-600
                            via-indigo-600
                            to-violet-600
                            relative">

                    <div class="absolute
                                inset-0
                                opacity-10">

                        <svg
                            class="w-full h-full"
                            viewBox="0 0 100 100"
                            preserveAspectRatio="none"
                        >
                            <circle
                                cx="10"
                                cy="10"
                                r="30"
                                fill="white"
                            />

                            <circle
                                cx="90"
                                cy="90"
                                r="40"
                                fill="white"
                            />
                        </svg>

                    </div>

                </div>


                {{-- PROFILE INFO --}}
                <div class="px-5 sm:px-8 pb-7">

                    <div class="-mt-14
                                flex flex-col
                                sm:flex-row
                                sm:items-end
                                gap-5">

                        {{-- FOTO --}}
                        <div class="relative flex-shrink-0">

                            @if($supervisor->photo)

                                <img
                                    src="{{ asset('storage/' . $supervisor->photo) }}"
                                    alt="Foto {{ $supervisor->name }}"
                                    class="w-28 h-28
                                           rounded-3xl
                                           object-cover
                                           border-4
                                           border-white
                                           shadow-lg"
                                >

                            @else

                                <div class="w-28 h-28
                                            rounded-3xl
                                            bg-white
                                            border-4
                                            border-white
                                            shadow-lg
                                            flex items-center
                                            justify-center">

                                    <div class="w-full h-full
                                                rounded-2xl
                                                bg-blue-100
                                                text-blue-700
                                                flex items-center
                                                justify-center
                                                text-4xl
                                                font-bold">

                                        {{ strtoupper(substr($supervisor->name, 0, 1)) }}

                                    </div>

                                </div>

                            @endif

                        </div>


                        {{-- NAMA --}}
                        <div class="flex-1 pb-1">

                            <div class="flex flex-wrap
                                        items-center
                                        gap-2">

                                <h2 class="text-2xl
                                           font-bold
                                           text-slate-800">

                                    {{ $supervisor->name }}

                                </h2>

                                <span class="inline-flex
                                             items-center
                                             gap-1.5
                                             px-3 py-1
                                             rounded-full
                                             bg-blue-100
                                             text-blue-700
                                             text-xs
                                             font-bold">

                                    <span class="w-1.5 h-1.5
                                                 rounded-full
                                                 bg-blue-600">
                                    </span>

                                    Pengawas

                                </span>

                            </div>

                            <p class="text-sm
                                      text-slate-500
                                      mt-1">

                                NIP: {{ $supervisor->nip }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- INFORMASI --}}
            <div class="grid grid-cols-1
                        md:grid-cols-2
                        xl:grid-cols-4
                        gap-4
                        mb-6">

                {{-- SEKOLAH --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            shadow-sm
                            p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-blue-100
                                    text-blue-600
                                    flex items-center
                                    justify-center">

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
                                    d="M3 21h18M5 21V5l7-3 7 3v16M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p class="text-xs
                                      font-semibold
                                      uppercase
                                      tracking-wider
                                      text-slate-400">
                                Sekolah Binaan
                            </p>

                            <p class="font-bold
                                      text-slate-700
                                      truncate
                                      mt-1">

                                {{ $supervisor->school->name ?? '-' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- NIP --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            shadow-sm
                            p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-indigo-100
                                    text-indigo-600
                                    flex items-center
                                    justify-center">

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
                                    d="M10 6h4M7 10h10M7 14h10M7 18h6M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs
                                      font-semibold
                                      uppercase
                                      tracking-wider
                                      text-slate-400">
                                NIP
                            </p>

                            <p class="font-bold
                                      text-slate-700
                                      mt-1">
                                {{ $supervisor->nip ?: '-' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- EMAIL --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            shadow-sm
                            p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-emerald-100
                                    text-emerald-600
                                    flex items-center
                                    justify-center">

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
                                    d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p class="text-xs
                                      font-semibold
                                      uppercase
                                      tracking-wider
                                      text-slate-400">
                                Email
                            </p>

                            <p class="font-bold
                                      text-slate-700
                                      truncate
                                      mt-1">

                                {{ $supervisor->email ?: '-' }}

                            </p>

                        </div>

                    </div>

                </div>


                {{-- PHONE --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            shadow-sm
                            p-5">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-amber-100
                                    text-amber-600
                                    flex items-center
                                    justify-center">

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
                                    d="M3 5a2 2 0 012-2h3l2 5-2 2a16 16 0 006 6l2-2 5 2v3a2 2 0 01-2 2C10.82 21 3 13.18 3 5z"
                                />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs
                                      font-semibold
                                      uppercase
                                      tracking-wider
                                      text-slate-400">
                                Nomor HP
                            </p>

                            <p class="font-bold
                                      text-slate-700
                                      mt-1">

                                {{ $supervisor->phone ?: '-' }}

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORM --}}
            <div class="bg-white
                        rounded-3xl
                        border border-slate-200
                        shadow-sm
                        overflow-hidden">

                {{-- FORM HEADER --}}
                <div class="px-5 sm:px-8
                            py-5
                            border-b border-slate-200
                            flex items-center gap-3">

                    <div class="w-11 h-11
                                rounded-xl
                                bg-blue-100
                                text-blue-600
                                flex items-center
                                justify-center">

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
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 17l-4 1 1-4 8.5-8.5z"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold
                                   text-slate-800
                                   text-lg">

                            Edit Profil

                        </h2>

                        <p class="text-sm text-slate-500">

                            Perbarui informasi profil pengawas.

                        </p>

                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('pengawas.profile.update') }}"
                    enctype="multipart/form-data"
                    class="p-5 sm:p-8"
                >

                    @csrf

                    @method('PUT')


                    <div class="grid grid-cols-1
                                lg:grid-cols-3
                                gap-8">

                        {{-- FOTO --}}
                        <div>

                            <div class="rounded-2xl
                                        border border-slate-200
                                        bg-slate-50
                                        p-5
                                        text-center">

                                <p class="font-bold
                                          text-slate-700
                                          mb-4">

                                    Foto Profil

                                </p>


                                @if($supervisor->photo)

                                    <img
                                        src="{{ asset('storage/' . $supervisor->photo) }}"
                                        class="w-32 h-32
                                               mx-auto
                                               rounded-3xl
                                               object-cover
                                               shadow-md
                                               border-4
                                               border-white"
                                    >

                                @else

                                    <div class="w-32 h-32
                                                mx-auto
                                                rounded-3xl
                                                bg-blue-100
                                                text-blue-700
                                                flex items-center
                                                justify-center
                                                text-5xl
                                                font-bold
                                                border-4
                                                border-white
                                                shadow-md">

                                        {{ strtoupper(substr($supervisor->name, 0, 1)) }}

                                    </div>

                                @endif


                                <label
                                    for="photo"
                                    class="mt-5
                                           inline-flex
                                           items-center
                                           gap-2
                                           cursor-pointer
                                           px-4 py-2.5
                                           rounded-xl
                                           bg-white
                                           border border-slate-300
                                           text-sm
                                           font-semibold
                                           text-slate-700
                                           hover:bg-slate-100
                                           transition"
                                >

                                    <svg
                                        class="w-4 h-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4-4 3 3 5-5 4 4M4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>

                                    Pilih Foto

                                </label>

                                <input
                                    type="file"
                                    name="photo"
                                    id="photo"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="hidden"
                                >

                                <p class="text-xs
                                          text-slate-400
                                          mt-3">

                                    JPG, PNG atau WEBP
                                    <br>
                                    Maksimal 2 MB

                                </p>

                            </div>

                        </div>


                        {{-- DATA --}}
                        <div class="lg:col-span-2">

                            <div class="grid grid-cols-1
                                        md:grid-cols-2
                                        gap-5">

                                {{-- NAMA --}}
                                <div class="md:col-span-2">

                                    <label
                                        for="name"
                                        class="block
                                               text-sm
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >
                                        Nama Lengkap
                                    </label>

                                    <div class="relative">

                                        <span class="absolute
                                                     left-4
                                                     top-1/2
                                                     -translate-y-1/2
                                                     text-slate-400">

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

                                        </span>

                                        <input
                                            type="text"
                                            name="name"
                                            id="name"
                                            value="{{ old('name', $supervisor->name) }}"
                                            required
                                            class="w-full
                                                   rounded-xl
                                                   border border-slate-300
                                                   pl-12 pr-4 py-3
                                                   text-sm
                                                   focus:border-blue-500
                                                   focus:ring-2
                                                   focus:ring-blue-100"
                                        >

                                    </div>

                                </div>


                                {{-- NIP --}}
                                <div>

                                    <label
                                        for="nip"
                                        class="block
                                               text-sm
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >
                                        NIP
                                    </label>

                                    <input
                                        type="text"
                                        name="nip"
                                        id="nip"
                                        value="{{ old('nip', $supervisor->nip) }}"
                                        required
                                        class="w-full
                                               rounded-xl
                                               border border-slate-300
                                               px-4 py-3
                                               text-sm
                                               focus:border-blue-500
                                               focus:ring-2
                                               focus:ring-blue-100"
                                    >

                                </div>


                                {{-- TELEPON --}}
                                <div>

                                    <label
                                        for="phone"
                                        class="block
                                               text-sm
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >
                                        Nomor HP
                                    </label>

                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        value="{{ old('phone', $supervisor->phone) }}"
                                        class="w-full
                                               rounded-xl
                                               border border-slate-300
                                               px-4 py-3
                                               text-sm
                                               focus:border-blue-500
                                               focus:ring-2
                                               focus:ring-blue-100"
                                    >

                                </div>


                                {{-- EMAIL --}}
                                <div class="md:col-span-2">

                                    <label
                                        for="email"
                                        class="block
                                               text-sm
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >
                                        Email
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        value="{{ old('email', $supervisor->email) }}"
                                        required
                                        class="w-full
                                               rounded-xl
                                               border border-slate-300
                                               px-4 py-3
                                               text-sm
                                               focus:border-blue-500
                                               focus:ring-2
                                               focus:ring-blue-100"
                                    >

                                </div>


                                {{-- PASSWORD --}}
                                <div>

                                    <label
                                        for="password"
                                        class="block
                                               text-sm
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >
                                        Password Baru
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        placeholder="Kosongkan jika tidak diubah"
                                        class="w-full
                                               rounded-xl
                                               border border-slate-300
                                               px-4 py-3
                                               text-sm
                                               focus:border-blue-500
                                               focus:ring-2
                                               focus:ring-blue-100"
                                    >

                                </div>


                                {{-- CONFIRM PASSWORD --}}
                                <div>

                                    <label
                                        for="password_confirmation"
                                        class="block
                                               text-sm
                                               font-bold
                                               text-slate-700
                                               mb-2"
                                    >
                                        Konfirmasi Password
                                    </label>

                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        placeholder="Ulangi password baru"
                                        class="w-full
                                               rounded-xl
                                               border border-slate-300
                                               px-4 py-3
                                               text-sm
                                               focus:border-blue-500
                                               focus:ring-2
                                               focus:ring-blue-100"
                                    >

                                </div>

                            </div>


                            {{-- SEKOLAH --}}
                            <div class="mt-5
                                        rounded-xl
                                        bg-slate-50
                                        border border-slate-200
                                        px-4 py-3">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10
                                                rounded-lg
                                                bg-blue-100
                                                text-blue-600
                                                flex items-center
                                                justify-center">

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
                                                d="M3 21h18M5 21V5l7-3 7 3v16M9 9h1m4 0h1m-6 4h1m4 0h1m-6 4h1m4 0h1"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-xs
                                                  font-semibold
                                                  text-slate-400
                                                  uppercase
                                                  tracking-wider">

                                            Sekolah Binaan

                                        </p>

                                        <p class="font-bold
                                                  text-slate-700">

                                            {{ $supervisor->school->name ?? '-' }}

                                        </p>

                                    </div>

                                </div>

                                <p class="text-xs
                                          text-slate-400
                                          mt-2
                                          ml-13">

                                    Sekolah binaan ditentukan oleh administrator
                                    dan tidak dapat diubah dari halaman ini.

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- BUTTON --}}
                    <div class="mt-8
                                pt-6
                                border-t border-slate-200
                                flex flex-col-reverse
                                sm:flex-row
                                sm:justify-end
                                gap-3">

                        <a
                            href="{{ route('pengawas.dashboard') }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-5 py-3
                                   rounded-xl
                                   border border-slate-300
                                   bg-white
                                   text-slate-700
                                   font-semibold
                                   text-sm
                                   hover:bg-slate-50
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
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>

                            Batal

                        </a>


                        <button
                            type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-6 py-3
                                   rounded-xl
                                   bg-blue-600
                                   hover:bg-blue-700
                                   text-white
                                   font-bold
                                   text-sm
                                   shadow-sm
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

                </form>

            </div>

        </section>

    </main>

</body>

</html>