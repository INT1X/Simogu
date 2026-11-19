<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detail Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex items-center gap-3">

                    <div class="w-2 h-8 bg-purple-600 rounded-full"></div>

                    <div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Detail Penilaian
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Detail hasil penilaian kinerja guru.
                        </p>

                    </div>

                </div>

            </div>

        </header>


        <section class="p-4 sm:p-6 lg:p-8">

            <div class="mb-6 flex flex-wrap gap-3">

                <a
                    href="{{ route('admin.assessments.index') }}"
                    class="px-5 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold"
                >
                    ← Kembali
                </a>

                <a
                    href="{{ route('admin.assessments.edit', $assessment) }}"
                    class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold"
                >
                    Edit Penilaian
                </a>

            </div>


            @if(session('success'))

                <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- DATA UTAMA --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 mb-6">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">
                            Guru
                        </p>

                        <p class="font-bold text-slate-800 mt-1">
                            {{ $assessment->teacher->name ?? '-' }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">
                            NIP
                        </p>

                        <p class="font-semibold text-slate-700 mt-1">
                            {{ $assessment->teacher->nip ?? '-' }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">
                            Pengawas
                        </p>

                        <p class="font-semibold text-slate-700 mt-1">
                            {{ $assessment->supervisor->name ?? '-' }}
                        </p>
                    </div>


                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold">
                            Tanggal
                        </p>

                        <p class="font-semibold text-slate-700 mt-1">
                            {{ $assessment->assessment_date?->format('d F Y') ?? '-' }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- KOMPETENSI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

                @foreach([
                    ['Pedagogik', $assessment->pedagogik_score],
                    ['Kepribadian', $assessment->kepribadian_score],
                    ['Sosial', $assessment->sosial_score],
                    ['Profesional', $assessment->profesional_score],
                ] as [$label, $score])

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">

                        <p class="text-sm text-slate-500">
                            {{ $label }}
                        </p>

                        <p class="text-3xl font-bold text-purple-600 mt-2">
                            {{ number_format((float) $score, 2, ',', '.') }}
                        </p>

                    </div>

                @endforeach

            </div>


            {{-- DETAIL --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

                <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                    <h2 class="font-bold text-slate-800">
                        Detail Indikator
                    </h2>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full min-w-[700px]">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Kode
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Kompetensi
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Indikator
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-bold text-slate-500 uppercase">
                                    Nilai
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Catatan
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($assessment->details as $detail)

                                <tr>

                                    <td class="px-5 py-4">

                                        <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700 text-xs font-bold">

                                            {{ $detail->indicator->code ?? '-' }}

                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">

                                        {{ $detail->indicator->competency ?? '-' }}

                                    </td>

                                    <td class="px-5 py-4 font-semibold text-slate-800">

                                        {{ $detail->indicator->name ?? '-' }}

                                    </td>

                                    <td class="px-5 py-4 text-center">

                                        <span class="font-bold text-purple-600">

                                            {{ number_format((float) $detail->score, 2, ',', '.') }}

                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-500">

                                        {{ $detail->notes ?: '-' }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="px-5 py-10 text-center text-slate-500">

                                        Belum ada detail indikator.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- HASIL --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                    <p class="text-sm text-slate-500">
                        Nilai Dokumen
                    </p>

                    <p class="text-3xl font-bold text-blue-600 mt-2">

                        {{ number_format((float) $assessment->document_score, 2, ',', '.') }}

                    </p>

                </div>


                <div class="bg-white rounded-2xl border border-purple-200 shadow-sm p-6">

                    <p class="text-sm text-slate-500">
                        Nilai Akhir
                    </p>

                    <p class="text-4xl font-bold text-purple-600 mt-2">

                        {{ number_format((float) $assessment->final_score, 2, ',', '.') }}

                    </p>

                </div>


                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">

                    <p class="text-sm text-slate-500">
                        Klasifikasi
                    </p>

                    <p class="text-xl font-bold text-slate-800 mt-3">

                        {{ $assessment->classification ?? '-' }}

                    </p>

                </div>

            </div>

        </section>

    </main>

</body>

</html>