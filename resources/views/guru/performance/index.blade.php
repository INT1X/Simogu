<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kinerja Saya - SIMOGU</title>

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

                            {{-- HAMBURGER --}}
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
                                    Kinerja Saya
                                </h1>

                                <p class="text-sm text-slate-500">
                                    Lihat hasil dan riwayat kinerja Anda
                                </p>

                            </div>

                        </div>


                        {{-- KANAN --}}
                        <div class="hidden sm:flex items-center gap-3">

                            <div class="w-10 h-10 rounded-full
                                        bg-blue-100 text-blue-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-chart-line"></i>

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
                                Kinerja Guru
                            </p>

                            <h2 class="text-2xl sm:text-3xl font-bold">
                                {{ $teacher->name }}
                            </h2>

                            <p class="text-blue-100 mt-2 max-w-2xl">
                                Pantau hasil penilaian kinerja Anda
                                berdasarkan penilaian yang telah dilakukan.
                            </p>

                        </div>


                        {{-- ICON / FOTO --}}
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

                                    <i class="fa-solid fa-chart-line text-3xl"></i>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- RINGKASAN --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


                    {{-- JUMLAH PENILAIAN --}}
                    <div class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm p-5">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Jumlah Penilaian
                                </p>

                                <p class="text-2xl font-bold text-slate-800 mt-1">
                                    {{ $assessmentCount }}
                                </p>

                            </div>

                            <div class="w-11 h-11 rounded-xl
                                        bg-blue-100 text-blue-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-clipboard-check"></i>

                            </div>

                        </div>

                    </div>


                    {{-- RATA-RATA --}}
                    <div class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm p-5">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Nilai Rata-rata
                                </p>

                                <p class="text-2xl font-bold text-slate-800 mt-1">

                                    {{ $averageScore !== null
                                        ? number_format((float) $averageScore, 2)
                                        : '-' }}

                                </p>

                            </div>

                            <div class="w-11 h-11 rounded-xl
                                        bg-indigo-100 text-indigo-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-chart-column"></i>

                            </div>

                        </div>

                    </div>


                    {{-- NILAI TERAKHIR --}}
                    <div class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm p-5">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Nilai Terakhir
                                </p>

                                <p class="text-2xl font-bold text-slate-800 mt-1">

                                    {{ $latestAssessment
                                        ? number_format((float) $latestAssessment->final_score, 2)
                                        : '-' }}

                                </p>

                            </div>

                            <div class="w-11 h-11 rounded-xl
                                        bg-emerald-100 text-emerald-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-star"></i>

                            </div>

                        </div>

                    </div>


                    {{-- PREDIKAT --}}
                    <div class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm p-5">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="text-sm text-slate-500">
                                    Predikat Terakhir
                                </p>

                                <p class="text-lg font-bold text-slate-800 mt-2">

                                    {{ $latestAssessment?->final_classification ?? '-' }}

                                </p>

                            </div>

                            <div class="w-11 h-11 rounded-xl
                                        bg-amber-100 text-amber-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-medal"></i>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- PENILAIAN TERAKHIR --}}
                @if ($latestAssessment)

                    <div class="bg-white rounded-2xl
                                border border-slate-200
                                shadow-sm overflow-hidden mb-6">

                        {{-- HEADER --}}
                        <div class="px-5 sm:px-6 py-5
                                    border-b border-slate-200">

                            <div class="flex items-center gap-3">

                                <div class="w-11 h-11 rounded-xl
                                            bg-blue-100 text-blue-600
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-chart-simple"></i>

                                </div>

                                <div>

                                    <h3 class="text-lg font-bold text-slate-800">
                                        Penilaian Terakhir
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Hasil penilaian kinerja terbaru Anda
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- BODY --}}
                        <div class="p-5 sm:p-6">

                            <div class="grid grid-cols-1 sm:grid-cols-2
                                        lg:grid-cols-4 gap-4">


                                {{-- PEDAGOGIK --}}
                                <div class="rounded-xl
                                            bg-slate-50
                                            border border-slate-200
                                            p-4">

                                    <div class="flex items-center gap-2 mb-2">

                                        <i class="fa-solid fa-book-open
                                                  text-blue-600"></i>

                                        <span class="text-sm
                                                     font-semibold
                                                     text-slate-600">

                                            Pedagogik

                                        </span>

                                    </div>

                                    <p class="text-2xl font-bold text-slate-800">

                                        {{ number_format((float) $latestAssessment->avg_pedagogik, 2) }}

                                    </p>

                                </div>


                                {{-- KEPRIBADIAN --}}
                                <div class="rounded-xl
                                            bg-slate-50
                                            border border-slate-200
                                            p-4">

                                    <div class="flex items-center gap-2 mb-2">

                                        <i class="fa-solid fa-user-check
                                                  text-indigo-600"></i>

                                        <span class="text-sm
                                                     font-semibold
                                                     text-slate-600">

                                            Kepribadian

                                        </span>

                                    </div>

                                    <p class="text-2xl font-bold text-slate-800">

                                        {{ number_format((float) $latestAssessment->avg_kepribadian, 2) }}

                                    </p>

                                </div>


                                {{-- SOSIAL --}}
                                <div class="rounded-xl
                                            bg-slate-50
                                            border border-slate-200
                                            p-4">

                                    <div class="flex items-center gap-2 mb-2">

                                        <i class="fa-solid fa-users
                                                  text-emerald-600"></i>

                                        <span class="text-sm
                                                     font-semibold
                                                     text-slate-600">

                                            Sosial

                                        </span>

                                    </div>

                                    <p class="text-2xl font-bold text-slate-800">

                                        {{ number_format((float) $latestAssessment->avg_sosial, 2) }}

                                    </p>

                                </div>


                                {{-- PROFESIONAL --}}
                                <div class="rounded-xl
                                            bg-slate-50
                                            border border-slate-200
                                            p-4">

                                    <div class="flex items-center gap-2 mb-2">

                                        <i class="fa-solid fa-user-tie
                                                  text-amber-600"></i>

                                        <span class="text-sm
                                                     font-semibold
                                                     text-slate-600">

                                            Profesional

                                        </span>

                                    </div>

                                    <p class="text-2xl font-bold text-slate-800">

                                        {{ number_format((float) $latestAssessment->avg_profesional, 2) }}

                                    </p>

                                </div>

                            </div>


                            {{-- NILAI AKHIR --}}
                            <div class="mt-5
                                        rounded-xl
                                        bg-blue-50
                                        border border-blue-100
                                        p-5">

                                <div class="flex flex-col sm:flex-row
                                            sm:items-center
                                            sm:justify-between gap-4">

                                    <div>

                                        <p class="text-sm text-blue-700">
                                            Nilai Akhir
                                        </p>

                                        <p class="text-3xl font-bold text-blue-800 mt-1">

                                            {{ number_format((float) $latestAssessment->final_score, 2) }}

                                        </p>

                                    </div>


                                    <div class="text-left sm:text-right">

                                        <p class="text-sm text-blue-700">
                                            Predikat
                                        </p>

                                        <p class="text-lg font-bold text-blue-800 mt-1">

                                            {{ $latestAssessment->final_classification }}

                                        </p>

                                    </div>

                                </div>

                            </div>


                            {{-- INFORMASI PENILAIAN --}}
                            <div class="mt-5
                                        grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-slate-100
                                                text-slate-600
                                                flex items-center justify-center">

                                        <i class="fa-solid fa-calendar"></i>

                                    </div>

                                    <div>

                                        <p class="text-xs text-slate-500">
                                            Tanggal Penilaian
                                        </p>

                                        <p class="text-sm font-semibold text-slate-800">

                                            {{ $latestAssessment->assessment_date
                                                ? $latestAssessment->assessment_date->format('d F Y')
                                                : '-' }}

                                        </p>

                                    </div>

                                </div>


                                <div class="flex items-center gap-3">

                                    <div class="w-10 h-10 rounded-lg
                                                bg-slate-100
                                                text-slate-600
                                                flex items-center justify-center">

                                        <i class="fa-solid fa-user-tie"></i>

                                    </div>

                                    <div>

                                        <p class="text-xs text-slate-500">
                                            Penilai
                                        </p>

                                        <p class="text-sm font-semibold text-slate-800">

                                            {{ $latestAssessment->supervisor?->name ?? '-' }}

                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- RIWAYAT PENILAIAN --}}
                <div class="bg-white rounded-2xl
                            border border-slate-200
                            shadow-sm overflow-hidden">

                    {{-- HEADER --}}
                    <div class="px-5 sm:px-6 py-5
                                border-b border-slate-200">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11 rounded-xl
                                        bg-indigo-100 text-indigo-600
                                        flex items-center justify-center">

                                <i class="fa-solid fa-clock-rotate-left"></i>

                            </div>

                            <div>

                                <h3 class="text-lg font-bold text-slate-800">
                                    Riwayat Penilaian
                                </h3>

                                <p class="text-sm text-slate-500 mt-1">
                                    Daftar seluruh penilaian kinerja Anda
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- TABEL --}}
                    <div class="overflow-x-auto">

                        @if ($assessments->count())

                            <table class="w-full text-sm">

                                <thead class="bg-slate-50
                                              border-b border-slate-200">

                                    <tr>

                                        <th class="px-5 py-4
                                                   text-left
                                                   font-semibold
                                                   text-slate-600">
                                            No
                                        </th>

                                        <th class="px-5 py-4
                                                   text-left
                                                   font-semibold
                                                   text-slate-600">
                                            Tanggal
                                        </th>

                                        <th class="px-5 py-4
                                                   text-left
                                                   font-semibold
                                                   text-slate-600">
                                            Penilai
                                        </th>

                                        <th class="px-5 py-4
                                                   text-center
                                                   font-semibold
                                                   text-slate-600">
                                            Nilai Akhir
                                        </th>

                                        <th class="px-5 py-4
                                                   text-center
                                                   font-semibold
                                                   text-slate-600">
                                            Predikat
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach ($assessments as $assessment)

                                        <tr class="hover:bg-slate-50">

                                            <td class="px-5 py-4 text-slate-600">

                                                {{ $loop->iteration }}

                                            </td>

                                            <td class="px-5 py-4 text-slate-700">

                                                {{ $assessment->assessment_date
                                                    ? $assessment->assessment_date->format('d F Y')
                                                    : '-' }}

                                            </td>

                                            <td class="px-5 py-4 text-slate-700">

                                                {{ $assessment->supervisor?->name ?? '-' }}

                                            </td>

                                            <td class="px-5 py-4
                                                       text-center
                                                       font-bold
                                                       text-slate-800">

                                                {{ number_format((float) $assessment->final_score, 2) }}

                                            </td>

                                            <td class="px-5 py-4 text-center">

                                                <span class="inline-flex
                                                             items-center
                                                             px-3 py-1
                                                             rounded-full
                                                             bg-blue-50
                                                             text-blue-700
                                                             text-xs
                                                             font-semibold">

                                                    {{ $assessment->final_classification ?? '-' }}

                                                </span>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        @else

                            {{-- BELUM ADA PENILAIAN --}}
                            <div class="px-6 py-14 text-center">

                                <div class="w-16 h-16 mx-auto
                                            rounded-2xl
                                            bg-slate-100
                                            text-slate-400
                                            flex items-center justify-center">

                                    <i class="fa-solid fa-chart-line text-2xl"></i>

                                </div>

                                <h4 class="mt-4
                                           text-lg
                                           font-bold
                                           text-slate-700">

                                    Belum Ada Penilaian

                                </h4>

                                <p class="mt-2
                                          text-sm
                                          text-slate-500
                                          max-w-md
                                          mx-auto">

                                    Belum terdapat data penilaian kinerja
                                    untuk akun guru Anda.

                                </p>

                            </div>

                        @endif

                    </div>

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