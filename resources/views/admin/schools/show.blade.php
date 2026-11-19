<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Sekolah - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- ========================================================= --}}
    {{-- SIDEBAR ADMIN --}}
    {{-- ========================================================= --}}

    @include('components.admin-sidebar')


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="min-h-screen lg:ml-72">

        {{-- ===================================================== --}}
        {{-- CONTENT WRAPPER --}}
        {{-- ===================================================== --}}

        <div class="px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

            <div class="max-w-6xl mx-auto">


                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <div class="mb-6 lg:mb-8">

                    {{-- Breadcrumb --}}

                    <div class="flex items-center gap-2 text-sm text-slate-500 mb-3">

                        <a href="{{ route('admin.schools.index') }}"
                            class="hover:text-blue-600 transition">

                            Data Sekolah

                        </a>

                        <span>/</span>

                        <span class="text-slate-400">
                            Detail
                        </span>

                    </div>


                    {{-- Header Content --}}

                    <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

                        <div class="min-w-0">

                            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                                Detail Sekolah
                            </h1>

                            <p class="mt-1.5 text-sm sm:text-base text-slate-500">
                                Informasi lengkap mengenai sekolah.
                            </p>

                        </div>


                        {{-- Action --}}

                        <div class="flex flex-wrap gap-2 sm:gap-3">

                            <a href="{{ route('admin.schools.index') }}"
                                class="inline-flex items-center justify-center gap-2
                                       px-4 py-2.5 rounded-xl
                                       bg-white border border-slate-200
                                       text-slate-700 font-semibold text-sm
                                       hover:bg-slate-50 hover:border-slate-300
                                       transition shadow-sm">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />

                                </svg>

                                Kembali

                            </a>


                            <a href="{{ route('admin.schools.edit', $school) }}"
                                class="inline-flex items-center justify-center gap-2
                                       px-4 py-2.5 rounded-xl
                                       bg-blue-600 text-white
                                       font-semibold text-sm
                                       hover:bg-blue-700
                                       transition shadow-sm">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                                           M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />

                                </svg>

                                Edit Sekolah

                            </a>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- SCHOOL HEADER CARD --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-2xl border border-slate-200
                            shadow-sm overflow-hidden mb-6">

                    <div class="relative overflow-hidden
                                bg-gradient-to-r from-blue-600 to-indigo-700
                                px-5 sm:px-6 lg:px-8 py-6 sm:py-8">

                        {{-- Background Decoration --}}

                        <div class="absolute -right-10 -top-10
                                    w-40 h-40 rounded-full bg-white/10">
                        </div>

                        <div class="absolute -right-20 -bottom-20
                                    w-56 h-56 rounded-full bg-white/5">
                        </div>


                        {{-- School Information --}}

                        <div class="relative flex flex-col sm:flex-row
                                    sm:items-center gap-5">

                            {{-- Icon --}}

                            <div class="flex-shrink-0">

                                <div class="w-16 h-16 sm:w-20 sm:h-20
                                            rounded-2xl
                                            bg-white/20 backdrop-blur-sm
                                            flex items-center justify-center
                                            border border-white/20">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-8 h-8 sm:w-10 sm:h-10 text-white"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor">

                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 21v-4h6v4M9 7h2m2 0h2M9 11h2m2 0h2M9 15h2m2 0h2" />

                                    </svg>

                                </div>

                            </div>


                            {{-- School Name --}}

                            <div class="min-w-0 text-white">

                                <p class="text-sm text-blue-100 mb-1">
                                    Data Sekolah
                                </p>

                                <h2 class="text-xl sm:text-2xl lg:text-3xl
                                           font-bold break-words">

                                    {{ $school->name }}

                                </h2>


                                @if($school->npsn)

                                    <div class="mt-3">

                                        <span class="inline-flex items-center
                                                     px-3 py-1 rounded-full
                                                     bg-white/15
                                                     text-xs sm:text-sm
                                                     font-medium">

                                            NPSN: {{ $school->npsn }}

                                        </span>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- INFORMATION --}}
                    {{-- ================================================= --}}

                    <div class="p-5 sm:p-6 lg:p-8">

                        {{-- Section Header --}}

                        <div class="flex items-center gap-3 mb-6">

                            <div class="w-10 h-10 rounded-xl
                                        bg-blue-50
                                        flex items-center justify-center
                                        flex-shrink-0">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5 text-blue-600"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                                </svg>

                            </div>


                            <div>

                                <h3 class="font-bold text-slate-800">
                                    Informasi Sekolah
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Detail informasi sekolah yang tersimpan.
                                </p>

                            </div>

                        </div>


                        {{-- Information Grid --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                            {{-- Nama Sekolah --}}

                            <div class="rounded-xl border border-slate-200
                                        p-4 sm:p-5
                                        hover:border-blue-200 transition">

                                <div class="flex items-start gap-4">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-blue-50
                                                flex items-center justify-center
                                                flex-shrink-0">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-blue-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0H5m14 0h2M9 7h1m-1 4h1m4-4h1m-1 4h1" />

                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-sm text-slate-500">
                                            Nama Sekolah
                                        </p>

                                        <p class="mt-1 font-semibold
                                                  text-slate-800 break-words">

                                            {{ $school->name ?: '-' }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- NPSN --}}

                            <div class="rounded-xl border border-slate-200
                                        p-4 sm:p-5
                                        hover:border-blue-200 transition">

                                <div class="flex items-start gap-4">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-indigo-50
                                                flex items-center justify-center
                                                flex-shrink-0">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-indigo-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />

                                        </svg>

                                    </div>


                                    <div>

                                        <p class="text-sm text-slate-500">
                                            NPSN
                                        </p>

                                        <p class="mt-1 font-semibold text-slate-800">
                                            {{ $school->npsn ?: '-' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Telepon --}}

                            <div class="rounded-xl border border-slate-200
                                        p-4 sm:p-5
                                        hover:border-blue-200 transition">

                                <div class="flex items-start gap-4">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-emerald-50
                                                flex items-center justify-center
                                                flex-shrink-0">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-emerald-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.129a11.042 11.042 0 005.502 5.502l1.129-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 15.72V19a2 2 0 01-2 2h-1C9.611 21 3 14.389 3 6V5z" />

                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-sm text-slate-500">
                                            No. Telepon
                                        </p>

                                        <p class="mt-1 font-semibold
                                                  text-slate-800 break-words">

                                            {{ $school->phone ?: '-' }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Email --}}

                            <div class="rounded-xl border border-slate-200
                                        p-4 sm:p-5
                                        hover:border-blue-200 transition">

                                <div class="flex items-start gap-4">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-purple-50
                                                flex items-center justify-center
                                                flex-shrink-0">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-purple-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />

                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-sm text-slate-500">
                                            Email Sekolah
                                        </p>

                                        <p class="mt-1 font-semibold
                                                  text-slate-800 break-words">

                                            {{ $school->email ?: '-' }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- Alamat --}}

                            <div class="md:col-span-2
                                        rounded-xl border border-slate-200
                                        p-4 sm:p-5
                                        hover:border-blue-200 transition">

                                <div class="flex items-start gap-4">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-orange-50
                                                flex items-center justify-center
                                                flex-shrink-0">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5 text-orange-600"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M17.657 16.657L13.414 21a2 2 0 01-2.828 0l-4.243-4.343a8 8 0 1111.314 0z" />

                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                                        </svg>

                                    </div>


                                    <div class="min-w-0">

                                        <p class="text-sm text-slate-500">
                                            Alamat Sekolah
                                        </p>

                                        <p class="mt-1 font-semibold
                                                  text-slate-800
                                                  leading-relaxed
                                                  break-words">

                                            {{ $school->address ?: '-' }}

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- SYSTEM INFORMATION --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-2xl border border-slate-200
                            shadow-sm p-5 sm:p-6 lg:p-8 mb-6">

                    <div class="flex items-center gap-3 mb-5">

                        <div class="w-10 h-10 rounded-xl
                                    bg-slate-100
                                    flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5 text-slate-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                            </svg>

                        </div>


                        <div>

                            <h3 class="font-bold text-slate-800">
                                Informasi Sistem
                            </h3>

                            <p class="text-sm text-slate-500">
                                Informasi waktu pencatatan data.
                            </p>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="rounded-xl bg-slate-50 p-4">

                            <p class="text-sm text-slate-500">
                                Ditambahkan
                            </p>

                            <p class="mt-1 font-semibold text-slate-700">
                                {{ $school->created_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>


                        <div class="rounded-xl bg-slate-50 p-4">

                            <p class="text-sm text-slate-500">
                                Terakhir diperbarui
                            </p>

                            <p class="mt-1 font-semibold text-slate-700">
                                {{ $school->updated_at?->format('d M Y, H:i') ?? '-' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- DANGER ZONE --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-2xl
                            border border-red-200
                            shadow-sm p-5 sm:p-6 lg:p-8">

                    <div class="flex flex-col lg:flex-row
                                lg:items-center
                                lg:justify-between gap-5">

                        <div>

                            <h3 class="font-bold text-red-700">
                                Hapus Data Sekolah
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                Data sekolah yang dihapus tidak dapat dikembalikan.
                            </p>

                        </div>


                        <form action="{{ route('admin.schools.destroy', $school) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sekolah ini?')">

                            @csrf

                            @method('DELETE')

                            <button type="submit"
                                class="w-full lg:w-auto
                                       inline-flex items-center
                                       justify-center gap-2
                                       px-5 py-2.5 rounded-xl
                                       bg-red-600 text-white
                                       font-semibold
                                       hover:bg-red-700
                                       transition">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />

                                </svg>

                                Hapus Sekolah

                            </button>

                        </form>

                    </div>

                </div>


                {{-- Bottom spacing --}}

                <div class="h-6"></div>

            </div>

        </div>

    </main>

</body>

</html>