<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Pengawas - SIMOGU</title>

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

        <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            <div class="max-w-5xl mx-auto">


                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <div class="mb-6">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                        {{-- Judul --}}
                        <div class="min-w-0">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-11 h-11 rounded-xl
                                           bg-blue-600 text-white
                                           flex items-center justify-center
                                           shadow-sm flex-shrink-0"
                                >

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-6 h-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                                        Detail Pengawas
                                    </h1>

                                    <p class="mt-1 text-sm sm:text-base text-slate-500">
                                        Informasi lengkap data pengawas sekolah.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Tombol --}}
                        <div class="flex flex-col sm:flex-row gap-2">

                            {{-- Edit --}}
                            <a
                                href="{{ route('admin.supervisors.edit', $supervisor) }}"
                                class="inline-flex items-center justify-center gap-2
                                       px-4 py-2.5 rounded-xl
                                       bg-blue-600 text-white
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
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13l-3.35.958.958-3.35a4.5 4.5 0 011.13-1.897L16.862 4.487z"
                                    />
                                </svg>

                                Edit

                            </a>


                            {{-- Kembali --}}
                            <a
                                href="{{ route('admin.supervisors.index') }}"
                                class="inline-flex items-center justify-center gap-2
                                       px-4 py-2.5 rounded-xl
                                       bg-white
                                       border border-slate-200
                                       text-slate-700
                                       font-semibold
                                       hover:bg-slate-100
                                       transition"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
                                    />
                                </svg>

                                Kembali

                            </a>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- CARD --}}
                {{-- ================================================= --}}

                <div
                    class="bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm
                           overflow-hidden"
                >


                    {{-- ================================================= --}}
                    {{-- PROFIL HEADER --}}
                    {{-- ================================================= --}}

                    <div class="px-5 sm:px-6 py-6 bg-gradient-to-r from-blue-600 to-indigo-600">

                        <div class="flex flex-col sm:flex-row sm:items-center gap-5">


                            {{-- FOTO --}}
                            <div class="shrink-0">

                                @if($supervisor->photo)

                                    <div
                                        class="w-24 h-24
                                               overflow-hidden
                                               rounded-2xl
                                               border-4 border-white/80
                                               shadow-lg
                                               bg-white"
                                    >

                                        <img
                                            src="{{ asset('storage/' . $supervisor->photo) }}"
                                            alt="{{ $supervisor->name }}"
                                            class="block w-full h-full object-cover object-center"
                                        >

                                    </div>

                                @else

                                    <div
                                        class="w-24 h-24
                                               rounded-2xl
                                               border-4 border-white/60
                                               bg-white/20
                                               flex items-center justify-center"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-12 h-12 text-white"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                                            />
                                        </svg>

                                    </div>

                                @endif

                            </div>


                            {{-- INFORMASI NAMA --}}
                            <div class="min-w-0 flex-1">

                                <h2 class="text-xl sm:text-2xl font-bold text-white break-words">
                                    {{ $supervisor->name }}
                                </h2>

                                <p class="text-blue-100 text-sm mt-1">
                                    Pengawas Sekolah
                                </p>


                                {{-- Status --}}
                                @if($supervisor->status === 'aktif')

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               mt-3 px-3 py-1.5
                                               rounded-full
                                               bg-emerald-400/20
                                               text-emerald-100
                                               text-xs font-semibold"
                                    >

                                        <span class="w-2 h-2 rounded-full bg-emerald-300"></span>

                                        Aktif

                                    </span>

                                @else

                                    <span
                                        class="inline-flex items-center gap-1.5
                                               mt-3 px-3 py-1.5
                                               rounded-full
                                               bg-red-400/20
                                               text-red-100
                                               text-xs font-semibold"
                                    >

                                        <span class="w-2 h-2 rounded-full bg-red-300"></span>

                                        Nonaktif

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- INFORMASI --}}
                    {{-- ================================================= --}}

                    <div class="p-5 sm:p-6">

                        <div class="flex items-center gap-3 mb-5">

                            <div
                                class="w-10 h-10 rounded-xl
                                       bg-blue-50 text-blue-600
                                       flex items-center justify-center
                                       flex-shrink-0"
                            >

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h3 class="font-bold text-slate-800">
                                    Informasi Pengawas
                                </h3>

                                <p class="text-sm text-slate-500">
                                    Data identitas, sekolah, dan kontak pengawas.
                                </p>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- GRID INFORMASI --}}
                        {{-- ================================================= --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                            {{-- NIP --}}
                            <div
                                class="rounded-2xl
                                       bg-blue-50
                                       border border-blue-100
                                       p-4"
                            >

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 shrink-0
                                               rounded-xl
                                               bg-blue-100
                                               text-blue-600
                                               flex items-center justify-center"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                                            />
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-xs text-blue-600 font-medium">
                                            NIP
                                        </p>

                                        <p class="font-semibold text-slate-800 break-all">
                                            {{ $supervisor->nip ?: '-' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- SEKOLAH --}}
                            <div
                                class="rounded-2xl
                                       bg-indigo-50
                                       border border-indigo-100
                                       p-4"
                            >

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 shrink-0
                                               rounded-xl
                                               bg-indigo-100
                                               text-indigo-600
                                               flex items-center justify-center"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-4h6v4M9 10h.01M12 10h.01M15 10h.01"
                                            />
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-xs text-indigo-600 font-medium">
                                            Sekolah
                                        </p>

                                        <p class="font-semibold text-slate-800 break-words">
                                            {{ $supervisor->school?->name ?: '-' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- TELEPON --}}
                            <div
                                class="rounded-2xl
                                       bg-emerald-50
                                       border border-emerald-100
                                       p-4"
                            >

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 shrink-0
                                               rounded-xl
                                               bg-emerald-100
                                               text-emerald-600
                                               flex items-center justify-center"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372a1.5 1.5 0 00-1.022-1.423l-3.48-1.16a1.5 1.5 0 00-1.681.611l-.97 1.293a12.04 12.04 0 01-5.403-5.403l1.293-.97a1.5 1.5 0 00.611-1.681l-1.16-3.48A1.5 1.5 0 008.515 5.75H7.25A2.25 2.25 0 005 8v2.25"
                                            />
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-xs text-emerald-600 font-medium">
                                            No. Telepon
                                        </p>

                                        <p class="font-semibold text-slate-800 break-all">
                                            {{ $supervisor->phone ?: '-' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- EMAIL --}}
                            <div
                                class="rounded-2xl
                                       bg-purple-50
                                       border border-purple-100
                                       p-4"
                            >

                                <div class="flex items-center gap-3">

                                    <div
                                        class="w-10 h-10 shrink-0
                                               rounded-xl
                                               bg-purple-100
                                               text-purple-600
                                               flex items-center justify-center"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-5 h-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M21.75 6.75v10.5A2.25 2.25 0 0119.5 19.5h-15a2.25 2.25 0 01-2.25-2.25V6.75M21.75 6.75L12 13.5 2.25 6.75"
                                            />
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <p class="text-xs text-purple-600 font-medium">
                                            Email
                                        </p>

                                        <p class="font-semibold text-slate-800 break-all">
                                            {{ $supervisor->email ?: '-' }}
                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- STATUS --}}
                            <div
                                class="md:col-span-2
                                       rounded-2xl
                                       bg-amber-50
                                       border border-amber-100
                                       p-4"
                            >

                                <div
                                    class="flex flex-col sm:flex-row
                                           sm:items-center
                                           sm:justify-between
                                           gap-4"
                                >

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 shrink-0
                                                   rounded-xl
                                                   bg-amber-100
                                                   text-amber-600
                                                   flex items-center justify-center"
                                        >

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                                />
                                            </svg>

                                        </div>

                                        <div>

                                            <p class="text-xs text-amber-600 font-medium">
                                                Status
                                            </p>

                                            <p class="font-semibold text-slate-800">
                                                Status Pengawas
                                            </p>

                                        </div>

                                    </div>


                                    @if($supervisor->status === 'aktif')

                                        <span
                                            class="inline-flex items-center justify-center
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-emerald-100
                                                   text-emerald-700
                                                   text-sm
                                                   font-bold"
                                        >

                                            <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>

                                            Aktif

                                        </span>

                                    @else

                                        <span
                                            class="inline-flex items-center justify-center
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-red-100
                                                   text-red-700
                                                   text-sm
                                                   font-bold"
                                        >

                                            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span>

                                            Nonaktif

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FOOTER --}}
                    {{-- ================================================= --}}

                    <div
                        class="px-5 sm:px-6 py-4
                               bg-slate-50
                               border-t border-slate-200"
                    >

                        <div
                            class="flex flex-col sm:flex-row
                                   sm:items-center
                                   sm:justify-between
                                   gap-2"
                        >

                            <p class="text-xs text-slate-500">
                                Data Pengawas SIMOGU
                            </p>

                            <p class="text-xs text-slate-400">
                                ID #{{ $supervisor->id }}
                            </p>

                        </div>

                    </div>

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