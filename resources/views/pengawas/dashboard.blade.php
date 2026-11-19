
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pengawas - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    {{-- SIDEBAR --}}
    @include('components.pengawas-sidebar')

    {{-- MAIN --}}
    <main class="min-h-screen lg:ml-64">

        {{-- HEADER --}}
        <header class="border-b border-slate-200 bg-white shadow-sm">
            <div class="px-4 py-6 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">
                            Dashboard Pengawas
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Pantau guru dan lakukan penilaian kinerja.
                        </p>
                    </div>

                    <div class="text-left sm:text-right">
                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()?->name ?? 'Pengawas' }}
                        </p>

                        <p class="text-sm text-blue-600">
                            Pengawas
                        </p>
                    </div>

                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">

            {{-- FLASH MESSAGE --}}
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                     role="status">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                     role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- WELCOME --}}
            <div class="mb-6">
                <div class="rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow-lg shadow-blue-500/20 sm:p-7">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                        <div>
                            <p class="text-sm font-medium text-blue-100">
                                Selamat datang kembali,
                            </p>

                            <h2 class="mt-1 text-2xl font-bold">
                                {{ auth()->user()?->name ?? 'Pengawas' }}
                            </h2>

                            <p class="mt-2 max-w-xl text-sm text-blue-100">
                                Kelola guru binaan, periksa dokumen pendukung,
                                dan lakukan penilaian kinerja guru melalui
                                dashboard pengawas.
                            </p>
                        </div>

                        <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl border border-white/20 bg-white/10">
                            <svg class="h-9 w-9 text-white"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="1.8"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>

                    </div>
                </div>
            </div>

            {{-- STATISTICS --}}
            <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- TOTAL GURU --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Total Guru
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-800">
                                {{ $totalTeachers ?? 0 }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Guru binaan
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-50">
                            <svg class="h-6 w-6 text-blue-600"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0zm5 0a3 3 0 11-6 0"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- BELUM DINILAI --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Belum Dinilai
                            </p>

                            <p class="mt-2 text-3xl font-bold text-orange-600">
                                {{ $pendingAssessments ?? 0 }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Perlu ditindaklanjuti
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-50">
                            <svg class="h-6 w-6 text-orange-600"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.52 20h14.96a2 2 0 001.73-3.14l-7.5-13a2 2 0 00-3.42 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- SUDAH DINILAI --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Sudah Dinilai
                            </p>

                            <p class="mt-2 text-3xl font-bold text-emerald-600">
                                {{ $completedAssessments ?? 0 }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Guru dengan nilai akhir
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-emerald-50">
                            <svg class="h-6 w-6 text-emerald-600"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- RATA-RATA NILAI --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Rata-rata Nilai
                            </p>

                            <p class="mt-2 text-3xl font-bold text-purple-600">
                                {{ isset($averageScore) && $averageScore !== null
    ? number_format((float) $averageScore, 2, ',', '.')
    : '0,00' }}
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Nilai penilaian guru binaan
                            </p>
                        </div>

                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-purple-50">
                            <svg class="h-6 w-6 text-purple-600"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M11 3v18m4-14h2a3 3 0 010 6h-2m0 0h2a3 3 0 010 6h-2M7 7h4a3 3 0 010 6H7m0 0h4a3 3 0 010 6H7"/>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            {{-- MAIN GRID --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                {{-- GURU BINAAN --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">

                    <div class="border-b border-slate-200 px-5 py-5 sm:px-6">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <h2 class="text-lg font-bold text-slate-800">
                                    Guru Binaan
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Daftar guru yang berada dalam pengawasan Anda.
                                </p>
                            </div>

                            <a href="{{ route('pengawas.teachers.index') }}"
                               class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                Lihat Semua

                                <svg class="h-4 w-4"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24"
                                     aria-hidden="true">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th scope="col" class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Guru
                                    </th>

                                    <th scope="col" class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Sekolah
                                    </th>

                                    <th scope="col" class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Status
                                    </th>

                                    <th scope="col" class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @forelse(($teachers ?? collect()) as $teacher)
                                    <tr class="transition hover:bg-slate-50">

                                        {{-- GURU --}}
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 font-bold text-blue-600">
                                                    {{ strtoupper(substr((string) ($teacher->name ?? '?'), 0, 1)) }}
                                                </div>

                                                <div class="min-w-0">
                                                    <p class="font-semibold text-slate-800">
                                                        {{ $teacher->name ?? '-' }}
                                                    </p>

                                                    @if(!empty($teacher->nip))
                                                        <p class="mt-1 text-xs text-slate-400">
                                                            NIP: {{ $teacher->nip }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        {{-- SEKOLAH --}}
                                        <td class="px-5 py-4">
                                            @if($teacher->school)
                                                <p class="text-sm font-medium text-slate-700">
                                                    {{ $teacher->school->name ?? '-' }}
                                                </p>
                                            @else
                                                <span class="text-sm text-slate-400">-</span>
                                            @endif
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-5 py-4 text-center">
                                            @if(($teacher->assessment_status ?? 'pending') === 'completed')
                                                <span class="inline-flex whitespace-nowrap rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700">
                                                    Sudah Dinilai
                                                </span>
                                            @else
                                                <span class="inline-flex whitespace-nowrap rounded-full bg-orange-50 px-3 py-1 text-xs font-bold text-orange-700">
                                                    Belum Dinilai
                                                </span>
                                            @endif
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-5 py-4 text-center">
                                            <a href="{{ route('pengawas.teachers.show', $teacher) }}"
                                               class="inline-flex items-center justify-center rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                                Lihat
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-12 text-center">
                                            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                                                <svg class="h-7 w-7 text-slate-400"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24"
                                                     aria-hidden="true">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0zm5 0a3 3 0 11-6 0"/>
                                                </svg>
                                            </div>

                                            <p class="font-semibold text-slate-700">
                                                Belum Ada Guru Binaan
                                            </p>

                                            <p class="mt-1 text-sm text-slate-400">
                                                Guru yang berada di sekolah binaan Anda akan muncul di sini.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- PENILAIAN TERBARU --}}
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-200 px-5 py-5">
                        <div class="flex items-center justify-between gap-3">

                            <div>
                                <h2 class="text-lg font-bold text-slate-800">
                                    Penilaian Terbaru
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    Aktivitas penilaian terakhir.
                                </p>
                            </div>

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-50">
                                <svg class="h-5 w-5 text-emerald-600"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24"
                                     aria-hidden="true">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>

                        </div>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse(($recentAssessments ?? collect()) as $assessment)
                            <div class="px-5 py-4 transition hover:bg-slate-50">

                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-slate-800">
                                            {{ $assessment->teacher->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-500">
                                            @php
                                                $assessmentDate = $assessment->assessment_date ?? null;
                                            @endphp

                                            @if($assessmentDate instanceof \DateTimeInterface)
                                                {{ $assessmentDate->format('d/m/Y') }}
                                            @elseif(!empty($assessmentDate))
                                                {{ \Illuminate\Support\Carbon::parse($assessmentDate)->format('d/m/Y') }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>

                                    @if($assessment->final_score !== null)
                                        <span class="inline-flex min-w-[58px] shrink-0 items-center justify-center rounded-lg bg-blue-50 px-2.5 py-1.5 text-sm font-bold text-blue-700">
                                            {{ number_format((float) $assessment->final_score, 2, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="shrink-0 text-xs text-slate-400">
                                            Belum ada nilai
                                        </span>
                                    @endif
                                </div>

                                @php
                                    $classification = strtolower(
                                        trim((string) ($assessment->classification ?? ''))
                                    );
                                @endphp

                                <div class="mt-3">
                                    @if($classification === 'sangat baik')
                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">
                                            Sangat Baik
                                        </span>
                                    @elseif($classification === 'baik')
                                        <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">
                                            Baik
                                        </span>
                                    @elseif($classification === 'cukup')
                                        <span class="inline-flex rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-bold text-yellow-700">
                                            Cukup
                                        </span>
                                    @elseif($classification === 'kurang')
                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-red-700">
                                            Kurang
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">
                                            Belum diklasifikasikan
                                        </span>
                                    @endif
                                </div>

                            </div>
                        @empty
                            <div class="px-5 py-12 text-center">
                                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                                    <svg class="h-7 w-7 text-slate-400"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24"
                                         aria-hidden="true">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2"/>
                                    </svg>
                                </div>

                                <p class="font-semibold text-slate-700">
                                    Belum Ada Penilaian
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Penilaian terbaru akan muncul di sini.
                                </p>
                            </div>
                        @endforelse
                    </div>

                    {{-- FOOTER PENILAIAN --}}
                    @if(($recentAssessments ?? collect())->isNotEmpty())
                        <div class="border-t border-slate-200 px-5 py-4">
                            <a href="{{ route('pengawas.assessments.history') }}"
                               class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                                Lihat Semua Penilaian

                                <svg class="h-4 w-4"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24"
                                     aria-hidden="true">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endif

                </div>

            </div>

            {{-- AKSI CEPAT --}}
            <div class="mt-6">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="mb-5">
                        <h2 class="text-lg font-bold text-slate-800">
                            Aksi Cepat
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Akses menu yang sering digunakan.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

                        {{-- DAFTAR GURU --}}
                        <a href="{{ route('pengawas.teachers.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-blue-300 hover:bg-blue-50/50">
                            <div class="flex items-center gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 transition group-hover:bg-blue-100">
                                    <svg class="h-5 w-5 text-blue-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24"
                                         aria-hidden="true">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0zm5 0a3 3 0 11-6 0"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Daftar Guru
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Lihat guru binaan
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- PENILAIAN --}}
                        <a href="{{ route('pengawas.assessments.index') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-emerald-300 hover:bg-emerald-50/50">
                            <div class="flex items-center gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50 transition group-hover:bg-emerald-100">
                                    <svg class="h-5 w-5 text-emerald-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24"
                                         aria-hidden="true">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-.664-.054-1.316-.156-1.956z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Penilaian
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Nilai kinerja guru
                                    </p>
                                </div>
                            </div>
                        </a>

                        {{-- RIWAYAT PENILAIAN --}}
                        <a href="{{ route('pengawas.assessments.history') }}"
                           class="group rounded-2xl border border-slate-200 p-5 transition hover:border-purple-300 hover:bg-purple-50/50">
                            <div class="flex items-center gap-4">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-purple-50 transition group-hover:bg-purple-100">
                                    <svg class="h-5 w-5 text-purple-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24"
                                         aria-hidden="true">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="font-bold text-slate-800">
                                        Riwayat Penilaian
                                    </p>

                                    <p class="mt-1 text-xs text-slate-500">
                                        Lihat riwayat penilaian guru
                                    </p>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>

        </section>
    </main>

</body>
</html>
