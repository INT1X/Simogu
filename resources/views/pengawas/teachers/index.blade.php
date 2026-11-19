<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Guru Binaan - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100">


    {{-- ========================================================= --}}
    {{-- SIDEBAR PENGAWAS --}}
    {{-- ========================================================= --}}

    @include('components.pengawas-sidebar')


    {{-- ========================================================= --}}
    {{-- MAIN --}}
    {{-- ========================================================= --}}

    <main class="lg:ml-64 min-h-screen">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-6">

                <div class="flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-4">

                    <div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Guru Binaan
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Daftar guru yang berada dalam pengawasan Anda.
                        </p>

                    </div>


                    {{-- USER --}}

                    <div class="flex items-center gap-3">

                        <div
                            class="w-11 h-11 rounded-xl
                                   bg-blue-100
                                   flex items-center justify-center"
                        >

                            <span class="font-bold text-blue-700">

                                {{ strtoupper(
                                    substr(
                                        auth()->user()->name ?? 'P',
                                        0,
                                        1
                                    )
                                ) }}

                            </span>

                        </div>


                        <div>

                            <p class="font-semibold text-slate-800">

                                {{ auth()->user()->name ?? 'Pengawas' }}

                            </p>

                            <p class="text-xs text-blue-600">
                                Pengawas
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </header>


        {{-- ===================================================== --}}
        {{-- CONTENT --}}
        {{-- ===================================================== --}}

        <section class="p-4 sm:p-6 lg:p-8">


            {{-- ================================================= --}}
            {{-- FLASH MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('success'))

                <div
                    class="mb-6 rounded-xl
                           border border-emerald-200
                           bg-emerald-50
                           px-5 py-4
                           text-sm text-emerald-700"
                >

                    <div class="flex items-center gap-3">

                        <svg
                            class="w-5 h-5 shrink-0"
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

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- ERROR MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('error'))

                <div
                    class="mb-6 rounded-xl
                           border border-red-200
                           bg-red-50
                           px-5 py-4
                           text-sm text-red-700"
                >

                    {{ session('error') }}

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- INFORMASI SEKOLAH --}}
            {{-- ================================================= --}}

            @if(isset($school) && $school)

                <div
                    class="mb-6
                           rounded-2xl
                           border border-blue-200
                           bg-blue-50
                           p-5"
                >

                    <div class="flex flex-col sm:flex-row
                                sm:items-center
                                gap-4">

                        <div
                            class="w-12 h-12 rounded-xl
                                   bg-white
                                   flex items-center justify-center
                                   shadow-sm"
                        >

                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2m-2 4h2m2-4h2m-2 4h2M9 21v-4h6v4"
                                />

                            </svg>

                        </div>


                        <div>

                            <p class="text-xs font-bold
                                      uppercase tracking-wider
                                      text-blue-500">

                                Sekolah Binaan

                            </p>

                            <h2 class="text-lg font-bold text-slate-800">

                                {{ $school->name }}

                            </h2>

                            @if($school->npsn ?? false)

                                <p class="text-xs text-slate-500 mt-1">

                                    NPSN: {{ $school->npsn }}

                                </p>

                            @endif

                        </div>

                    </div>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- STATISTICS --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">


                {{-- TOTAL --}}

                <div
                    class="bg-white
                           rounded-2xl
                           border border-slate-200
                           shadow-sm
                           p-5"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-bold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Total Guru

                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-800">

                                {{ isset($teachers) ? $teachers->count() : 0 }}

                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Guru binaan
                            </p>

                        </div>


                        <div
                            class="w-12 h-12 rounded-xl
                                   bg-blue-50
                                   flex items-center justify-center"
                        >

                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0zm5 0a3 3 0 11-6 0"
                                />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- SUDAH DINILAI --}}

                <div
                    class="bg-white
                           rounded-2xl
                           border border-slate-200
                           shadow-sm
                           p-5"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-bold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Sudah Dinilai

                            </p>

                            <p class="mt-2 text-3xl font-bold text-emerald-600">

                                {{ $completedTeachers ?? 0 }}

                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Penilaian selesai
                            </p>

                        </div>


                        <div
                            class="w-12 h-12 rounded-xl
                                   bg-emerald-50
                                   flex items-center justify-center"
                        >

                            <svg
                                class="w-6 h-6 text-emerald-600"
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

                    </div>

                </div>


                {{-- BELUM DINILAI --}}

                <div
                    class="bg-white
                           rounded-2xl
                           border border-slate-200
                           shadow-sm
                           p-5"
                >

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-bold
                                      uppercase tracking-wider
                                      text-slate-400">

                                Belum Dinilai

                            </p>

                            <p class="mt-2 text-3xl font-bold text-orange-600">

                                {{ $pendingTeachers ?? 0 }}

                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Perlu ditindaklanjuti
                            </p>

                        </div>


                        <div
                            class="w-12 h-12 rounded-xl
                                   bg-orange-50
                                   flex items-center justify-center"
                        >

                            <svg
                                class="w-6 h-6 text-orange-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.52 20h14.96a2 2 0 001.73-3.14l-7.5-13a2 2 0 00-3.42 0z"
                                />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- DAFTAR GURU --}}
            {{-- ================================================= --}}

            <div
                class="bg-white
                       rounded-2xl
                       border border-slate-200
                       shadow-sm
                       overflow-hidden"
            >


                {{-- HEADER TABLE --}}

                <div
                    class="px-5 sm:px-6 py-5
                           border-b border-slate-200"
                >

                    <div class="flex flex-col
                                lg:flex-row
                                lg:items-center
                                lg:justify-between
                                gap-4">

                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Daftar Guru Binaan
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Guru dari sekolah yang berada dalam tanggung
                                jawab pengawasan Anda.
                            </p>

                        </div>


                        {{-- SEARCH --}}

                        <form
                            method="GET"
                            action="{{ route('pengawas.teachers.index') }}"
                            class="w-full lg:w-80"
                        >

                            <div class="relative">

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari nama atau NIP guru..."
                                    class="w-full
                                           rounded-xl
                                           border border-slate-200
                                           bg-slate-50
                                           pl-11 pr-4 py-3
                                           text-sm
                                           text-slate-700
                                           outline-none
                                           focus:border-blue-400
                                           focus:ring-2
                                           focus:ring-blue-100
                                           transition"
                                >

                                <svg
                                    class="absolute left-4 top-3.5
                                           w-5 h-5 text-slate-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"
                                    />

                                </svg>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TABLE --}}
                {{-- ================================================= --}}

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th
                                    class="px-5 py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >
                                    Guru
                                </th>


                                <th
                                    class="px-5 py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >
                                    NIP
                                </th>


                                <th
                                    class="px-5 py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >
                                    Sekolah
                                </th>


                                <th
                                    class="px-5 py-4
                                           text-center
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >
                                    Status
                                </th>


                                <th
                                    class="px-5 py-4
                                           text-center
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">


                            @forelse($teachers ?? [] as $teacher)

                                <tr class="hover:bg-slate-50 transition">


                                    {{-- ================================================= --}}
                                    {{-- GURU --}}
                                    {{-- ================================================= --}}

                                    <td class="px-5 py-4">

                                        <div class="flex items-center gap-3">


                                            {{-- AVATAR --}}

                                            <div
                                                class="w-11 h-11
                                                       shrink-0
                                                       rounded-xl
                                                       bg-blue-50
                                                       flex items-center
                                                       justify-center
                                                       text-blue-600
                                                       font-bold"
                                            >

                                                {{ strtoupper(
                                                    substr(
                                                        $teacher->name ?? 'G',
                                                        0,
                                                        1
                                                    )
                                                ) }}

                                            </div>


                                            {{-- NAMA --}}

                                            <div class="min-w-0">

                                                <p
                                                    class="font-semibold
                                                           text-slate-800
                                                           truncate"
                                                >

                                                    {{ $teacher->name ?? '-' }}

                                                </p>


                                                @if(isset($teacher->email))

                                                    <p
                                                        class="text-xs
                                                               text-slate-400
                                                               mt-1
                                                               truncate"
                                                    >

                                                        {{ $teacher->email }}

                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- NIP --}}
                                    {{-- ================================================= --}}

                                    <td class="px-5 py-4">

                                        @if(!empty($teacher->nip))

                                            <span class="text-sm text-slate-600">

                                                {{ $teacher->nip }}

                                            </span>

                                        @else

                                            <span class="text-sm text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- SEKOLAH --}}
                                    {{-- ================================================= --}}

                                    <td class="px-5 py-4">

                                        @if(isset($teacher->school) && $teacher->school)

                                            <div>

                                                <p
                                                    class="text-sm
                                                           font-medium
                                                           text-slate-700"
                                                >

                                                    {{ $teacher->school->name }}

                                                </p>

                                                @if($teacher->school->npsn ?? false)

                                                    <p
                                                        class="text-xs
                                                               text-slate-400
                                                               mt-1"
                                                    >

                                                        NPSN:
                                                        {{ $teacher->school->npsn }}

                                                    </p>

                                                @endif

                                            </div>

                                        @else

                                            <span class="text-sm text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- STATUS PENILAIAN --}}
                                    {{-- ================================================= --}}

                                    <td class="px-5 py-4 text-center">

                                        @php

                                            $status = $teacher->assessment_status
                                                ?? null;

                                        @endphp


                                        @if(
                                            $status === 'completed' ||
                                            $status === 'selesai'
                                        )

                                            <span
                                                class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       px-3 py-1.5
                                                       rounded-full
                                                       bg-emerald-50
                                                       text-emerald-700
                                                       text-xs
                                                       font-bold"
                                            >

                                                <span
                                                    class="w-1.5 h-1.5
                                                           rounded-full
                                                           bg-emerald-500"
                                                ></span>

                                                Sudah Dinilai

                                            </span>

                                        @else

                                            <span
                                                class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       px-3 py-1.5
                                                       rounded-full
                                                       bg-orange-50
                                                       text-orange-700
                                                       text-xs
                                                       font-bold"
                                            >

                                                <span
                                                    class="w-1.5 h-1.5
                                                           rounded-full
                                                           bg-orange-500"
                                                ></span>

                                                Belum Dinilai

                                            </span>

                                        @endif

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- AKSI --}}
                                    {{-- ================================================= --}}

                                    <td class="px-5 py-4 text-center">

                                        <a
                                            href="{{ route(
                                                'pengawas.teachers.show',
                                                $teacher
                                            ) }}"
                                            class="inline-flex
                                                   items-center
                                                   justify-center
                                                   gap-2
                                                   px-3.5 py-2
                                                   rounded-lg
                                                   bg-blue-50
                                                   hover:bg-blue-100
                                                   text-blue-700
                                                   text-xs
                                                   font-semibold
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
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />

                                            </svg>

                                            Lihat

                                        </a>

                                    </td>

                                </tr>


                            @empty


                                {{-- ================================================= --}}
                                {{-- EMPTY --}}
                                {{-- ================================================= --}}

                                <tr>

                                    <td
                                        colspan="5"
                                        class="px-5 py-16 text-center"
                                    >

                                        <div
                                            class="flex flex-col
                                                   items-center
                                                   justify-center"
                                        >

                                            <div
                                                class="w-16 h-16
                                                       rounded-2xl
                                                       bg-slate-100
                                                       flex items-center
                                                       justify-center
                                                       mb-4"
                                            >

                                                <svg
                                                    class="w-8 h-8
                                                           text-slate-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0zm5 0a3 3 0 11-6 0"
                                                    />

                                                </svg>

                                            </div>


                                            <p
                                                class="font-bold
                                                       text-slate-700"
                                            >

                                                @if(request('search'))

                                                    Guru Tidak Ditemukan

                                                @else

                                                    Belum Ada Guru Binaan

                                                @endif

                                            </p>


                                            <p
                                                class="text-sm
                                                       text-slate-400
                                                       mt-1
                                                       max-w-md"
                                            >

                                                @if(request('search'))

                                                    Tidak ada guru yang sesuai
                                                    dengan pencarian
                                                    "{{ request('search') }}".

                                                @else

                                                    Guru dari sekolah yang berada
                                                    dalam tanggung jawab Anda
                                                    akan muncul di sini.

                                                @endif

                                            </p>


                                            @if(request('search'))

                                                <a
                                                    href="{{ route(
                                                        'pengawas.teachers.index'
                                                    ) }}"
                                                    class="mt-4
                                                           inline-flex
                                                           items-center
                                                           px-4 py-2
                                                           rounded-xl
                                                           bg-slate-100
                                                           hover:bg-slate-200
                                                           text-slate-700
                                                           text-sm
                                                           font-semibold"
                                                >

                                                    Reset Pencarian

                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforelse


                        </tbody>

                    </table>

                </div>


                {{-- ================================================= --}}
                {{-- PAGINATION --}}
                {{-- ================================================= --}}

                @if(
                    isset($teachers) &&
                    method_exists($teachers, 'links')
                )

                    <div
                        class="px-5 sm:px-6 py-4
                               border-t border-slate-200"
                    >

                        {{ $teachers->withQueryString()->links() }}

                    </div>

                @endif


            </div>


            {{-- ================================================= --}}
            {{-- INFORMASI --}}
            {{-- ================================================= --}}

            <div
                class="mt-6
                       rounded-2xl
                       border border-slate-200
                       bg-white
                       p-5"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="w-10 h-10
                               shrink-0
                               rounded-xl
                               bg-blue-50
                               flex items-center
                               justify-center"
                    >

                        <svg
                            class="w-5 h-5 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                            />

                        </svg>

                    </div>


                    <div>

                        <h3 class="font-bold text-slate-800">
                            Informasi Guru Binaan
                        </h3>

                        <p class="text-sm text-slate-500 mt-1 leading-relaxed">

                            Daftar guru di halaman ini berasal dari sekolah
                            yang menjadi tanggung jawab Anda. Anda dapat
                            melihat informasi guru dan melanjutkan ke proses
                            penilaian melalui menu yang tersedia.

                        </p>

                    </div>

                </div>

            </div>


        </section>

    </main>


</body>

</html>