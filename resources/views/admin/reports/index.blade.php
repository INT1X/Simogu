<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100">

    {{-- ========================================================= --}}
    {{-- SIDEBAR ADMIN --}}
    {{-- ========================================================= --}}

    @include('components.admin-sidebar')


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="lg:ml-64 min-h-screen">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div>

                        <div class="flex items-center gap-3">

                            <div class="w-12 h-12 rounded-2xl
                                        bg-gradient-to-br from-yellow-400 to-orange-500
                                        flex items-center justify-center
                                        shadow-lg shadow-orange-500/20">

                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />

                                </svg>

                            </div>


                            <div>

                                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                                    Laporan Penilaian
                                </h1>

                                <p class="text-sm text-slate-500 mt-1">
                                    Rekap hasil penilaian kinerja guru
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="text-left sm:text-right">

                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-sm text-emerald-600">
                            Administrator
                        </p>

                    </div>

                </div>

            </div>

        </header>


        {{-- ===================================================== --}}
        {{-- CONTENT --}}
        {{-- ===================================================== --}}

        <section class="p-4 sm:p-6 lg:p-8">


            {{-- ================================================= --}}
            {{-- STATISTIK --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">


                {{-- TOTAL --}}

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Total Penilaian
                            </p>

                            <p class="mt-2 text-3xl font-bold text-slate-800">
                                {{ $totalAssessments }}
                            </p>

                        </div>


                        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">

                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5h6m-7 4h8m-8 4h5m-7 8h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- SANGAT BAIK --}}

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Sangat Baik
                            </p>

                            <p class="mt-2 text-3xl font-bold text-emerald-600">
                                {{ $veryGood }}
                            </p>

                        </div>


                        <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">

                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- BAIK --}}

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Baik
                            </p>

                            <p class="mt-2 text-3xl font-bold text-blue-600">
                                {{ $good }}
                            </p>

                        </div>


                        <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center">

                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- CUKUP --}}

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Cukup
                            </p>

                            <p class="mt-2 text-3xl font-bold text-yellow-600">
                                {{ $fair }}
                            </p>

                        </div>


                        <div class="w-11 h-11 rounded-xl bg-yellow-50 flex items-center justify-center">

                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.73-3L13.73 4a2 2 0 00-3.46 0L3.34 16a2 2 0 001.73 3z" />

                            </svg>

                        </div>

                    </div>

                </div>


                {{-- RATA-RATA --}}

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                                Rata-rata
                            </p>

                            <p class="mt-2 text-3xl font-bold text-purple-600">

                                {{ $averageScore !== null
    ? number_format((float) $averageScore, 2)
    : '0.00'
                                }}

                            </p>

                        </div>


                        <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center">

                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3v18m4-14h2a3 3 0 010 6h-2m0 0h2a3 3 0 010 6h-2M7 7h4a3 3 0 010 6H7m0 0h4a3 3 0 010 6H7" />

                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- FILTER --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">


                <div class="flex items-center gap-3 mb-5">

                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center">

                        <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19a1 1 0 01-.553.894l-4 2A1 1 0 019 21v-8.586L3.293 6.707A1 1 0 013 6V4z" />

                        </svg>

                    </div>


                    <div>

                        <h2 class="font-bold text-slate-800">
                            Filter Laporan
                        </h2>

                        <p class="text-xs text-slate-500">
                            Gunakan filter untuk menampilkan data tertentu
                        </p>

                    </div>

                </div>


                <form method="GET" action="{{ route('admin.reports.index') }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">


                        {{-- SEKOLAH --}}

                        <div>

                            <label class="block text-xs font-semibold text-slate-600 mb-2">
                                Sekolah
                            </label>

                            <select name="school_id"
                                class="w-full rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                                <option value="">
                                    Semua Sekolah
                                </option>

                                @foreach($schools as $school)

                                    <option value="{{ $school->id }}" @selected(request('school_id') == $school->id)>
                                        {{ $school->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- PENGAWAS --}}

                        <div>

                            <label class="block text-xs font-semibold text-slate-600 mb-2">
                                Pengawas
                            </label>

                            <select name="supervisor_id"
                                class="w-full rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                                <option value="">
                                    Semua Pengawas
                                </option>

                                @foreach($supervisors as $supervisor)

                                    <option value="{{ $supervisor->id }}"
                                        @selected(request('supervisor_id') == $supervisor->id)>
                                        {{ $supervisor->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- STATUS --}}

                        <div>

                            <label class="block text-xs font-semibold text-slate-600 mb-2">
                                Status
                            </label>

                            <select name="status"
                                class="w-full rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                                <option value="">
                                    Semua Status
                                </option>

                                <option value="draft" @selected(request('status') === 'draft')>
                                    Draft
                                </option>

                                <option value="submitted" @selected(request('status') === 'submitted')>
                                    Submitted
                                </option>

                                <option value="completed" @selected(request('status') === 'completed')>
                                    Completed
                                </option>

                            </select>

                        </div>


                        {{-- DARI TANGGAL --}}

                        <div>

                            <label class="block text-xs font-semibold text-slate-600 mb-2">
                                Dari Tanggal
                            </label>

                            <input type="date" name="date_from" value="{{ request('date_from') }}"
                                class="w-full rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                        </div>


                        {{-- SAMPAI TANGGAL --}}

                        <div>

                            <label class="block text-xs font-semibold text-slate-600 mb-2">
                                Sampai Tanggal
                            </label>

                            <input type="date" name="date_to" value="{{ request('date_to') }}"
                                class="w-full rounded-xl border border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500">

                        </div>

                    </div>


                    {{-- BUTTON --}}

                    <div class="flex flex-wrap gap-3 mt-5">

                        <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition">

                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011 1v2a1 1 0 01-.293.707L9 13.414V21l6-3v-4.586l5.293-5.293A1 1 0 0020 7V5a1 1 0 00-1-1H3z" />

                            </svg>

                            Terapkan Filter

                        </button>


                        <a href="{{ route('admin.reports.index') }}"
                            class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-slate-100 text-slate-700 text-sm font-semibold hover:bg-slate-200 transition">
                            Reset
                        </a>

                    </div>

                </form>

            </div>


            {{-- ================================================= --}}
            {{-- TABLE --}}
            {{-- ================================================= --}}

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


                {{-- TABLE HEADER --}}

                <div class="px-5 py-4 border-b border-slate-200
                            flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-3">

                    <div>

                        <h2 class="font-bold text-slate-800">
                            Rekap Penilaian Guru
                        </h2>

                        <p class="text-xs text-slate-500 mt-1">
                            Data hasil penilaian yang dilakukan oleh pengawas
                        </p>

                    </div>


                    <div class="text-xs text-slate-500">

                        Menampilkan

                        <span class="font-semibold text-slate-700">
                            {{ $assessments->firstItem() ?? 0 }}
                        </span>

                        -

                        <span class="font-semibold text-slate-700">
                            {{ $assessments->lastItem() ?? 0 }}
                        </span>

                        dari

                        <span class="font-semibold text-slate-700">
                            {{ $assessments->total() }}
                        </span>

                    </div>

                </div>


                {{-- TABLE --}}

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead class="bg-slate-50">

                            <tr>

                                <th
                                    class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    No
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Guru
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Sekolah
                                </th>

                                <th
                                    class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Pengawas
                                </th>

                                <th
                                    class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Tanggal
                                </th>

                                <th
                                    class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Nilai Akhir
                                </th>

                                <th
                                    class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Klasifikasi
                                </th>

                                <th
                                    class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">


                            @forelse($assessments as $index => $assessment)

                                <tr class="hover:bg-slate-50 transition">


                                    {{-- NO --}}

                                    <td class="px-5 py-4 text-slate-500">

                                        {{ ($assessments->firstItem() ?? 1) + $index }}

                                    </td>


                                    {{-- GURU --}}

                                    <td class="px-5 py-4">

                                        @if($assessment->teacher)

                                            <div>

                                                <p class="font-semibold text-slate-800">

                                                    {{ $assessment->teacher->name }}

                                                </p>


                                                @if($assessment->teacher->nip)

                                                    <p class="text-xs text-slate-400 mt-1">

                                                        NIP:
                                                        {{ $assessment->teacher->nip }}

                                                    </p>

                                                @endif

                                            </div>

                                        @else

                                            <span class="text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- SEKOLAH --}}

                                    <td class="px-5 py-4">

                                        @if($assessment->teacher?->school)

                                            <p class="font-medium text-slate-700">

                                                {{ $assessment->teacher->school->name }}

                                            </p>

                                        @else

                                            <span class="text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- PENGAWAS --}}

                                    <td class="px-5 py-4">

                                        @if($assessment->supervisor)

                                            <p class="font-medium text-slate-700">

                                                {{ $assessment->supervisor->name }}

                                            </p>

                                        @else

                                            <span class="text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- TANGGAL --}}

                                    <td class="px-5 py-4 text-center">

                                        @if($assessment->assessment_date)

                                            {{ $assessment->assessment_date->format('d/m/Y') }}

                                        @else

                                            -

                                        @endif

                                    </td>


                                    {{-- NILAI AKHIR --}}

                                    <td class="px-5 py-4 text-center">

                                        @if($assessment->final_score !== null)

                                            <span class="inline-flex items-center justify-center
                                                                 min-w-[70px] px-3 py-1.5
                                                                 rounded-lg bg-blue-50
                                                                 text-blue-700 font-bold">

                                                {{ number_format((float) $assessment->final_score, 2) }}

                                            </span>

                                        @else

                                            <span class="text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- KLASIFIKASI --}}

                                    <td class="px-5 py-4 text-center">

                                        @php

                                            $classification = strtolower(
                                                trim((string) $assessment->classification)
                                            );

                                        @endphp


                                        @if($classification === 'sangat baik')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-emerald-50
                                                                 text-emerald-700
                                                                 text-xs font-bold">

                                                Sangat Baik

                                            </span>

                                        @elseif($classification === 'baik')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-blue-50
                                                                 text-blue-700
                                                                 text-xs font-bold">

                                                Baik

                                            </span>

                                        @elseif($classification === 'cukup')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-yellow-50
                                                                 text-yellow-700
                                                                 text-xs font-bold">

                                                Cukup

                                            </span>

                                        @elseif($classification === 'kurang')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-red-50
                                                                 text-red-700
                                                                 text-xs font-bold">

                                                Kurang

                                            </span>

                                        @else

                                            <span class="text-slate-400">
                                                -
                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUS --}}

                                    <td class="px-5 py-4 text-center">

                                        @php

                                            $status = strtolower(
                                                trim((string) $assessment->status)
                                            );

                                        @endphp


                                        @if($status === 'completed')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-emerald-50
                                                                 text-emerald-700
                                                                 text-xs font-bold">

                                                Selesai

                                            </span>

                                        @elseif($status === 'submitted')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-blue-50
                                                                 text-blue-700
                                                                 text-xs font-bold">

                                                Submitted

                                            </span>

                                        @elseif($status === 'draft')

                                            <span class="inline-flex px-3 py-1.5
                                                                 rounded-full bg-yellow-50
                                                                 text-yellow-700
                                                                 text-xs font-bold">

                                                Draft

                                            </span>

                                        @else

                                            <span class="text-slate-400">

                                                {{ $assessment->status ?: '-' }}

                                            </span>

                                        @endif

                                    </td>

                                </tr>


                            @empty


                                <tr>

                                    <td colspan="8" class="px-5 py-16 text-center">

                                        <div class="flex flex-col items-center justify-center">


                                            <div class="w-16 h-16 rounded-2xl
                                                            bg-slate-100
                                                            flex items-center justify-center
                                                            mb-4">

                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">

                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2v14a2 2 0 002 2z" />

                                                </svg>

                                            </div>


                                            <h3 class="font-semibold text-slate-700">

                                                Belum Ada Data Penilaian

                                            </h3>


                                            <p class="text-sm text-slate-400 mt-1">

                                                Data penilaian guru akan muncul
                                                setelah dilakukan oleh pengawas.

                                            </p>

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

                @if($assessments->hasPages())

                    <div class="px-5 py-4 border-t border-slate-200">

                        {{ $assessments->links() }}

                    </div>

                @endif


            </div>

        </section>

    </main>

</body>

</html>