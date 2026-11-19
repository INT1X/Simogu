<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Laporan Penilaian - SIMOGU</title>

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

                <div class="flex flex-col lg:flex-row
                            lg:items-center
                            lg:justify-between
                            gap-4">

                    <div>

                        <div class="flex items-center gap-2 mb-2">

                            <span class="w-9 h-9
                                         rounded-xl
                                         bg-purple-100
                                         text-purple-600
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
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 9H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v13a2 2 0 01-2 2z"
                                    />
                                </svg>

                            </span>

                            <span class="text-sm font-semibold text-purple-600">
                                Laporan Pengawas
                            </span>

                        </div>


                        <h1 class="text-2xl sm:text-3xl
                                   font-bold text-slate-800">

                            Laporan Penilaian Guru

                        </h1>


                        <p class="text-sm text-slate-500 mt-1">

                            Rekap hasil penilaian guru binaan Anda.

                        </p>

                    </div>


                    <div class="text-left lg:text-right">

                        <p class="font-semibold text-slate-800">
                            {{ $supervisor->name }}
                        </p>

                        <p class="text-sm text-purple-600">
                            Pengawas
                        </p>

                    </div>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">


            {{-- INFORMASI SEKOLAH --}}
            <div class="bg-gradient-to-r
                        from-purple-600
                        to-indigo-600
                        rounded-2xl
                        p-5 sm:p-6
                        text-white
                        mb-6
                        shadow-sm">

                <div class="flex items-center gap-4">

                    <div class="w-12 h-12
                                rounded-xl
                                bg-white/15
                                flex items-center
                                justify-center">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2m-2 4h2m4-4h2m-2 4h2"
                            />
                        </svg>

                    </div>


                    <div>

                        <p class="text-sm text-purple-100">
                            Sekolah Binaan
                        </p>

                        <h2 class="text-xl font-bold">
                            {{ $supervisor->school->name ?? '-' }}
                        </h2>

                        <p class="text-sm text-purple-100 mt-1">
                            NPSN:
                            {{ $supervisor->school->npsn ?? '-' }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- STATISTIK --}}
            <div class="grid grid-cols-1
                        sm:grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


                {{-- TOTAL PENILAIAN --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            p-5
                            shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Total Penilaian
                            </p>

                            <p class="text-3xl
                                      font-bold
                                      text-slate-800
                                      mt-1">

                                {{ $totalAssessments }}

                            </p>

                        </div>


                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-blue-100
                                    text-blue-600
                                    flex items-center
                                    justify-center">

                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5h6"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- RATA RATA --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            p-5
                            shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Rata-rata Nilai
                            </p>

                            <p class="text-3xl
                                      font-bold
                                      text-indigo-600
                                      mt-1">

                                {{ $averageScore !== null
                                    ? number_format((float) $averageScore, 2)
                                    : '-' }}

                            </p>

                        </div>


                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-indigo-100
                                    text-indigo-600
                                    flex items-center
                                    justify-center">

                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11 3v18m4-16l4 4-4 4m-4 4l-4 4 4 4"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- GURU --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            p-5
                            shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Guru Binaan
                            </p>

                            <p class="text-3xl
                                      font-bold
                                      text-purple-600
                                      mt-1">

                                {{ $totalTeachers }}

                            </p>

                            <p class="text-xs text-slate-400 mt-1">

                                {{ $assessedTeachers }} sudah dinilai

                            </p>

                        </div>


                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-purple-100
                                    text-purple-600
                                    flex items-center
                                    justify-center">

                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5V4H2v16h5m10 0v-6H7v6m10 0H7"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- SANGAT BAIK --}}
                <div class="bg-white
                            rounded-2xl
                            border border-slate-200
                            p-5
                            shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm text-slate-500">
                                Sangat Baik
                            </p>

                            <p class="text-3xl
                                      font-bold
                                      text-emerald-600
                                      mt-1">

                                {{ $veryGood }}

                            </p>

                        </div>


                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-emerald-100
                                    text-emerald-600
                                    flex items-center
                                    justify-center">

                            <svg
                                class="w-6 h-6"
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

            </div>


            {{-- FILTER --}}
            <div class="bg-white
                        rounded-2xl
                        border border-slate-200
                        shadow-sm
                        mb-6">

                <div class="px-5 sm:px-6 py-5
                            border-b border-slate-200">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10
                                    rounded-xl
                                    bg-slate-100
                                    text-slate-600
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
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L14 12.414V19l-4 2v-8.586L3.293 6.707A1 1 0 013 6V4z"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="font-bold text-slate-800">
                                Filter Laporan
                            </h2>

                            <p class="text-sm text-slate-500">
                                Gunakan filter untuk mencari hasil tertentu.
                            </p>

                        </div>

                    </div>

                </div>


                <form
                    method="GET"
                    action="{{ route('pengawas.reports.index') }}"
                    class="p-5 sm:p-6"
                >

                    <div class="grid grid-cols-1
                                sm:grid-cols-2
                                lg:grid-cols-5
                                gap-4">


                        {{-- GURU --}}
                        <div>

                            <label class="block
                                          text-sm
                                          font-semibold
                                          text-slate-700
                                          mb-2">

                                Guru

                            </label>

                            <select
                                name="teacher_id"
                                class="w-full
                                       rounded-xl
                                       border border-slate-300
                                       px-4 py-3
                                       text-sm
                                       focus:border-purple-500
                                       focus:ring-2
                                       focus:ring-purple-100"
                            >

                                <option value="">
                                    Semua Guru
                                </option>

                                @foreach($teachers as $teacher)

                                    <option
                                        value="{{ $teacher->id }}"
                                        @selected(request('teacher_id') == $teacher->id)
                                    >
                                        {{ $teacher->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- STATUS --}}
                        <div>

                            <label class="block
                                          text-sm
                                          font-semibold
                                          text-slate-700
                                          mb-2">

                                Status

                            </label>

                            <select
                                name="status"
                                class="w-full
                                       rounded-xl
                                       border border-slate-300
                                       px-4 py-3
                                       text-sm
                                       focus:border-purple-500
                                       focus:ring-2
                                       focus:ring-purple-100"
                            >

                                <option value="">
                                    Semua Status
                                </option>

                                <option
                                    value="draft"
                                    @selected(request('status') === 'draft')
                                >
                                    Draft
                                </option>

                                <option
                                    value="selesai"
                                    @selected(request('status') === 'selesai')
                                >
                                    Selesai
                                </option>

                            </select>

                        </div>


                        {{-- KLASIFIKASI --}}
                        <div>

                            <label class="block
                                          text-sm
                                          font-semibold
                                          text-slate-700
                                          mb-2">

                                Klasifikasi

                            </label>

                            <select
                                name="classification"
                                class="w-full
                                       rounded-xl
                                       border border-slate-300
                                       px-4 py-3
                                       text-sm
                                       focus:border-purple-500
                                       focus:ring-2
                                       focus:ring-purple-100"
                            >

                                <option value="">
                                    Semua Klasifikasi
                                </option>

                                <option
                                    value="Sangat Baik"
                                    @selected(request('classification') === 'Sangat Baik')
                                >
                                    Sangat Baik
                                </option>

                                <option
                                    value="Baik"
                                    @selected(request('classification') === 'Baik')
                                >
                                    Baik
                                </option>

                                <option
                                    value="Cukup"
                                    @selected(request('classification') === 'Cukup')
                                >
                                    Cukup
                                </option>

                                <option
                                    value="Kurang"
                                    @selected(request('classification') === 'Kurang')
                                >
                                    Kurang
                                </option>

                            </select>

                        </div>


                        {{-- DARI --}}
                        <div>

                            <label class="block
                                          text-sm
                                          font-semibold
                                          text-slate-700
                                          mb-2">

                                Dari Tanggal

                            </label>

                            <input
                                type="date"
                                name="date_from"
                                value="{{ request('date_from') }}"
                                class="w-full
                                       rounded-xl
                                       border border-slate-300
                                       px-4 py-3
                                       text-sm
                                       focus:border-purple-500
                                       focus:ring-2
                                       focus:ring-purple-100"
                            >

                        </div>


                        {{-- SAMPAI --}}
                        <div>

                            <label class="block
                                          text-sm
                                          font-semibold
                                          text-slate-700
                                          mb-2">

                                Sampai Tanggal

                            </label>

                            <input
                                type="date"
                                name="date_to"
                                value="{{ request('date_to') }}"
                                class="w-full
                                       rounded-xl
                                       border border-slate-300
                                       px-4 py-3
                                       text-sm
                                       focus:border-purple-500
                                       focus:ring-2
                                       focus:ring-purple-100"
                            >

                        </div>

                    </div>


                    <div class="flex flex-wrap
                                gap-3
                                mt-5">

                        <button
                            type="submit"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-5 py-3
                                   rounded-xl
                                   bg-purple-600
                                   hover:bg-purple-700
                                   text-white
                                   font-bold
                                   text-sm
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
                                    d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                            Terapkan Filter

                        </button>


                        <a
                            href="{{ route('pengawas.reports.index') }}"
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

                            Reset

                        </a>

                    </div>

                </form>

            </div>


            {{-- RINGKASAN KLASIFIKASI --}}
            <div class="grid grid-cols-2
                        lg:grid-cols-4
                        gap-4
                        mb-6">


                <div class="bg-white
                            border border-emerald-200
                            rounded-2xl
                            p-5">

                    <p class="text-sm text-slate-500">
                        Sangat Baik
                    </p>

                    <p class="text-2xl
                              font-bold
                              text-emerald-600
                              mt-1">

                        {{ $veryGood }}

                    </p>

                </div>


                <div class="bg-white
                            border border-blue-200
                            rounded-2xl
                            p-5">

                    <p class="text-sm text-slate-500">
                        Baik
                    </p>

                    <p class="text-2xl
                              font-bold
                              text-blue-600
                              mt-1">

                        {{ $good }}

                    </p>

                </div>


                <div class="bg-white
                            border border-amber-200
                            rounded-2xl
                            p-5">

                    <p class="text-sm text-slate-500">
                        Cukup
                    </p>

                    <p class="text-2xl
                              font-bold
                              text-amber-600
                              mt-1">

                        {{ $fair }}

                    </p>

                </div>


                <div class="bg-white
                            border border-red-200
                            rounded-2xl
                            p-5">

                    <p class="text-sm text-slate-500">
                        Kurang
                    </p>

                    <p class="text-2xl
                              font-bold
                              text-red-600
                              mt-1">

                        {{ $poor }}

                    </p>

                </div>

            </div>


            {{-- TABEL --}}
            <div class="bg-white
                        rounded-2xl
                        border border-slate-200
                        shadow-sm
                        overflow-hidden">

                <div class="px-5 sm:px-6 py-5
                            border-b border-slate-200">

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10
                                    rounded-xl
                                    bg-purple-100
                                    text-purple-600
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
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 9H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v13a2 2 0 01-2 2z"
                                />
                            </svg>

                        </div>

                        <div>

                            <h2 class="font-bold text-slate-800">
                                Hasil Penilaian
                            </h2>

                            <p class="text-sm text-slate-500">
                                Data penilaian guru binaan.
                            </p>

                        </div>

                    </div>

                </div>


                @if($assessments->count())

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-5 py-4 text-left
                                               font-bold text-slate-600">
                                        Guru
                                    </th>

                                    <th class="px-5 py-4 text-left
                                               font-bold text-slate-600">
                                        Tanggal
                                    </th>

                                    <th class="px-5 py-4 text-center
                                               font-bold text-slate-600">
                                        Nilai
                                    </th>

                                    <th class="px-5 py-4 text-center
                                               font-bold text-slate-600">
                                        Klasifikasi
                                    </th>

                                    <th class="px-5 py-4 text-center
                                               font-bold text-slate-600">
                                        Status
                                    </th>

                                    <th class="px-5 py-4 text-center
                                               font-bold text-slate-600">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-slate-100">

                                @foreach($assessments as $assessment)

                                    <tr class="hover:bg-slate-50 transition">

                                        {{-- GURU --}}
                                        <td class="px-5 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="w-10 h-10
                                                            rounded-xl
                                                            bg-purple-100
                                                            text-purple-700
                                                            flex items-center
                                                            justify-center
                                                            font-bold">

                                                    {{ strtoupper(
                                                        substr(
                                                            $assessment->teacher->name ?? '?',
                                                            0,
                                                            1
                                                        )
                                                    ) }}

                                                </div>


                                                <div>

                                                    <p class="font-bold text-slate-800">

                                                        {{ $assessment->teacher->name ?? '-' }}

                                                    </p>

                                                    <p class="text-xs text-slate-500">

                                                        {{ $assessment->teacher->subject ?? '-' }}

                                                    </p>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- TANGGAL --}}
                                        <td class="px-5 py-4">

                                            <p class="font-medium text-slate-700">

                                                {{ $assessment->assessment_date
                                                    ? $assessment->assessment_date->format('d/m/Y')
                                                    : '-' }}

                                            </p>

                                        </td>


                                        {{-- NILAI --}}
                                        <td class="px-5 py-4 text-center">

                                            <span class="text-xl
                                                         font-bold
                                                         text-slate-800">

                                                {{ $assessment->final_score !== null
                                                    ? number_format(
                                                        (float) $assessment->final_score,
                                                        2
                                                    )
                                                    : '-' }}

                                            </span>

                                        </td>


                                        {{-- KLASIFIKASI --}}
                                        <td class="px-5 py-4 text-center">

                                            @php

                                                $classificationClass = match(
                                                    $assessment->classification
                                                ) {

                                                    'Sangat Baik'
                                                        => 'bg-emerald-100 text-emerald-700',

                                                    'Baik'
                                                        => 'bg-blue-100 text-blue-700',

                                                    'Cukup'
                                                        => 'bg-amber-100 text-amber-700',

                                                    'Kurang'
                                                        => 'bg-red-100 text-red-700',

                                                    default
                                                        => 'bg-slate-100 text-slate-600',
                                                };

                                            @endphp


                                            <span
                                                class="inline-flex
                                                       items-center
                                                       px-3 py-1
                                                       rounded-full
                                                       text-xs
                                                       font-bold
                                                       {{ $classificationClass }}"
                                            >

                                                {{ $assessment->classification ?? '-' }}

                                            </span>

                                        </td>


                                        {{-- STATUS --}}
                                        <td class="px-5 py-4 text-center">

                                            @php

                                                $statusClass = match(
                                                    $assessment->status
                                                ) {

                                                    'selesai'
                                                        => 'bg-emerald-100 text-emerald-700',

                                                    'draft'
                                                        => 'bg-amber-100 text-amber-700',

                                                    default
                                                        => 'bg-slate-100 text-slate-600',
                                                };

                                            @endphp


                                            <span
                                                class="inline-flex
                                                       items-center
                                                       px-3 py-1
                                                       rounded-full
                                                       text-xs
                                                       font-semibold
                                                       {{ $statusClass }}"
                                            >

                                                {{ ucfirst($assessment->status ?? '-') }}

                                            </span>

                                        </td>


                                        {{-- AKSI --}}
                                        <td class="px-5 py-4 text-center">

                                            <a
                                                href="{{ route(
                                                    'pengawas.assessments.show',
                                                    $assessment
                                                ) }}"
                                                class="inline-flex
                                                       items-center
                                                       gap-2
                                                       px-3 py-2
                                                       rounded-lg
                                                       bg-blue-50
                                                       text-blue-600
                                                       hover:bg-blue-100
                                                       font-semibold
                                                       text-xs
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

                                                Detail

                                            </a>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINATION --}}
                    <div class="px-5 sm:px-6 py-5
                                border-t border-slate-200">

                        {{ $assessments->links() }}

                    </div>

                @else

                    <div class="px-6 py-16 text-center">

                        <div class="w-16 h-16
                                    mx-auto
                                    rounded-2xl
                                    bg-slate-100
                                    text-slate-400
                                    flex items-center
                                    justify-center">

                            <svg
                                class="w-8 h-8"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 9H7a2 2 0 01-2-2V5a2 2 0 012-2h10a2 2 0 012 2v13a2 2 0 01-2 2z"
                                />
                            </svg>

                        </div>


                        <h3 class="mt-4
                                   font-bold
                                   text-slate-800">

                            Belum Ada Data Penilaian

                        </h3>


                        <p class="text-sm
                                  text-slate-500
                                  mt-1">

                            Belum ada penilaian yang sesuai dengan filter.

                        </p>

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>