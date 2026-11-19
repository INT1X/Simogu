<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100">


    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}

    @include('components.admin-sidebar')


    {{-- ========================================================= --}}
    {{-- MAIN --}}
    {{-- ========================================================= --}}

    <main class="lg:ml-64 min-h-screen w-auto">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="w-full px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">


                    {{-- ================================================= --}}
                    {{-- JUDUL --}}
                    {{-- ================================================= --}}

                    <div class="flex items-start gap-3">

                        {{-- Ruang hamburger mobile --}}

                        <div class="w-10 shrink-0 lg:hidden"></div>


                        <div>

                            <div class="flex items-center gap-2">

                                <div class="w-2 h-8 bg-blue-600 rounded-full"></div>

                                <h2 class="text-2xl font-bold text-slate-800">

                                    Dashboard Admin

                                </h2>

                            </div>


                            <p class="text-slate-500 mt-1">

                                Selamat datang di Sistem Monitoring Kinerja Guru

                            </p>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- USER --}}
                    {{-- ================================================= --}}

                    <div class="text-left sm:text-right ml-12 sm:ml-0">

                        <p class="font-semibold text-slate-800">

                            {{ auth()->user()->name }}

                        </p>


                        <div class="inline-flex items-center gap-1 mt-1">

                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                            <p class="text-sm text-emerald-600">

                                Administrator

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </header>


        {{-- ===================================================== --}}
        {{-- CONTENT --}}
        {{-- ===================================================== --}}

        <section class="w-full p-4 sm:p-6 lg:p-8">


            {{-- ================================================= --}}
            {{-- STATISTIK --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">


                {{-- ================================================= --}}
                {{-- GURU --}}
                {{-- ================================================= --}}

                <div class="group bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm p-6
                           hover:shadow-lg
                           hover:-translate-y-1
                           transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">

                                Total Guru

                            </p>


                            <h3 class="text-3xl font-bold text-slate-800 mt-2">

                                {{ $totalTeachers }}

                            </h3>


                            <p class="text-xs text-blue-600 mt-2">

                                Data guru terdaftar

                            </p>

                        </div>


                        <div class="w-14 h-14 rounded-2xl
                                   bg-blue-50
                                   flex items-center justify-center
                                   group-hover:scale-110
                                   transition">

                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6z" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- SEKOLAH --}}
                {{-- ================================================= --}}

                <div class="group bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm p-6
                           hover:shadow-lg
                           hover:-translate-y-1
                           transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">

                                Total Sekolah

                            </p>


                            <h3 class="text-3xl font-bold text-slate-800 mt-2">

                                {{ $totalSchools }}

                            </h3>


                            <p class="text-xs text-emerald-600 mt-2">

                                Sekolah terdaftar

                            </p>

                        </div>


                        <div class="w-14 h-14 rounded-2xl
                                   bg-emerald-50
                                   flex items-center justify-center
                                   group-hover:scale-110
                                   transition">

                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-8h6v8" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- PENGAWAS --}}
                {{-- ================================================= --}}

                <div class="group bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm p-6
                           hover:shadow-lg
                           hover:-translate-y-1
                           transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">

                                Total Pengawas

                            </p>


                            <h3 class="text-3xl font-bold text-slate-800 mt-2">

                                {{ $totalSupervisors }}

                            </h3>


                            <p class="text-xs text-purple-600 mt-2">

                                Pengawas terdaftar

                            </p>

                        </div>


                        <div class="w-14 h-14 rounded-2xl
                                   bg-purple-50
                                   flex items-center justify-center
                                   group-hover:scale-110
                                   transition">

                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- PENILAIAN --}}
                {{-- ================================================= --}}

                <div class="group bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm p-6
                           hover:shadow-lg
                           hover:-translate-y-1
                           transition duration-300">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-slate-500 text-sm font-medium">

                                Penilaian

                            </p>


                            <h3 class="text-3xl font-bold text-slate-800 mt-2">

                                {{ $totalAssessments }}

                            </h3>


                            <p class="text-xs text-orange-600 mt-2">

                                Total penilaian

                            </p>

                        </div>


                        <div class="w-14 h-14 rounded-2xl
                                   bg-orange-50
                                   flex items-center justify-center
                                   group-hover:scale-110
                                   transition">

                            <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5-2a9 9 0 11-18 0 9 9 0 0118 0z" />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- WELCOME --}}
            {{-- ================================================= --}}

            <div class="mt-5
                       bg-gradient-to-r from-blue-600 to-indigo-600
                       rounded-2xl shadow-lg
                       p-6 text-white">

                <div class="flex items-start gap-4">


                    <div class="w-12 h-12 rounded-xl
                               bg-white/20
                               flex items-center justify-center
                               shrink-0">

                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />

                        </svg>

                    </div>


                    <div>

                        <h3 class="text-xl font-bold">

                            Sistem Monitoring Kinerja Guru

                        </h3>


                        <p class="text-blue-100 mt-2">

                            Anda login sebagai Administrator.
                            Gunakan menu di sebelah kiri untuk mengelola
                            data sekolah, guru, pengawas, dan penilaian kinerja.

                        </p>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- RINGKASAN --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mt-5">


                {{-- ================================================= --}}
                {{-- DATA GURU --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm p-6
                           hover:shadow-md transition">

                    <div class="flex items-center justify-between mb-5">

                        <h3 class="font-bold text-slate-800">

                            Data Guru

                        </h3>


                        <a href="{{ route('admin.teachers.index') }}" class="text-sm text-blue-600
                                   hover:text-blue-700
                                   font-semibold">

                            Lihat semua →

                        </a>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-xl
                                   bg-blue-50
                                   flex items-center justify-center">

                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8z" />

                            </svg>

                        </div>


                        <div>

                            <p class="text-2xl font-bold text-slate-800">

                                {{ $totalTeachers }}

                            </p>


                            <p class="text-sm text-slate-500">

                                Guru terdaftar dalam sistem

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- DATA PENGAWAS --}}
                {{-- ================================================= --}}

                <div class="bg-white rounded-2xl
                           border border-slate-200
                           shadow-sm p-6
                           hover:shadow-md transition">

                    <div class="flex items-center justify-between mb-5">

                        <h3 class="font-bold text-slate-800">

                            Data Pengawas

                        </h3>


                        <a href="{{ route('admin.supervisors.index') }}" class="text-sm text-purple-600
                                   hover:text-purple-700
                                   font-semibold">

                            Lihat semua →

                        </a>

                    </div>


                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-xl
                                   bg-purple-50
                                   flex items-center justify-center">

                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                            </svg>

                        </div>


                        <div>

                            <p class="text-2xl font-bold text-slate-800">

                                {{ $totalSupervisors }}

                            </p>


                            <p class="text-sm text-slate-500">

                                Pengawas terdaftar dalam sistem

                            </p>

                        </div>

                    </div>

                </div>

            </div>


        </section>


    </main>


</body>

</html>