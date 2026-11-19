<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Penilaian Kinerja Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-start gap-3">

                        <div class="w-10 shrink-0 lg:hidden"></div>

                        <div>

                            <div class="flex items-center gap-3">

                                <div class="w-2 h-8 bg-purple-600 rounded-full"></div>

                                <div>

                                    <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                                        Penilaian Kinerja Guru
                                    </h1>

                                    <p class="text-sm sm:text-base text-slate-500 mt-1">
                                        Kelola penilaian kinerja guru oleh pengawas.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="text-left sm:text-right ml-12 sm:ml-0">

                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <div class="inline-flex items-center gap-1.5 mt-1">

                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                            <p class="text-sm text-emerald-600">
                                Administrator
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">

            {{-- FLASH SUCCESS --}}
            @if(session('success'))

                <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4">

                    {{ session('success') }}

                </div>

            @endif


            {{-- ERROR --}}
            @if($errors->any())

                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 text-red-800 px-5 py-4">

                    <p class="font-semibold">
                        Terdapat kesalahan:
                    </p>

                    <ul class="list-disc list-inside mt-2 text-sm">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- TOOLBAR --}}
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>

                    <h2 class="text-lg font-bold text-slate-800">
                        Data Penilaian
                    </h2>

                    <p class="text-sm text-slate-500">
                        Daftar hasil penilaian kinerja guru.
                    </p>

                </div>


                <a
                    href="{{ route('admin.assessments.create') }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold shadow-sm transition"
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
                            d="M12 4v16m8-8H4"
                        />

                    </svg>

                    Tambah Penilaian

                </a>

            </div>


            {{-- TABLE --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[900px]">

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    No
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Guru
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Pengawas
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Tanggal
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Nilai Akhir
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Klasifikasi
                                </th>

                                <th class="px-5 py-4 text-right text-xs font-bold text-slate-500 uppercase">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($assessments as $assessment)

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-5 py-4 text-sm text-slate-600">

                                        {{ $assessments->firstItem() + $loop->index }}

                                    </td>


                                    <td class="px-5 py-4">

                                        <p class="font-semibold text-slate-800">

                                            {{ $assessment->teacher->name ?? '-' }}

                                        </p>

                                        <p class="text-xs text-slate-500 mt-1">

                                            {{ $assessment->teacher->nip ?? '-' }}

                                        </p>

                                    </td>


                                    <td class="px-5 py-4 text-sm text-slate-700">

                                        {{ $assessment->supervisor->name ?? '-' }}

                                    </td>


                                    <td class="px-5 py-4 text-sm text-slate-600">

                                        {{ $assessment->assessment_date?->format('d/m/Y') ?? '-' }}

                                    </td>


                                    <td class="px-5 py-4">

                                        <span class="font-bold text-purple-600">

                                            {{ number_format((float) $assessment->final_score, 2, ',', '.') }}

                                        </span>

                                    </td>


                                    <td class="px-5 py-4">

                                        @php

                                            $classification = strtolower((string) $assessment->classification);

                                            $badge = match ($classification) {
                                                'sangat baik' => 'bg-emerald-100 text-emerald-700',
                                                'baik' => 'bg-blue-100 text-blue-700',
                                                'cukup' => 'bg-amber-100 text-amber-700',
                                                default => 'bg-red-100 text-red-700',
                                            };

                                        @endphp

                                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold {{ $badge }}">

                                            {{ $assessment->classification ?? '-' }}

                                        </span>

                                    </td>


                                    <td class="px-5 py-4">

                                        <div class="flex justify-end items-center gap-2">

                                            <a
                                                href="{{ route('admin.assessments.show', $assessment) }}"
                                                class="px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold"
                                            >
                                                Detail
                                            </a>


                                            <a
                                                href="{{ route('admin.assessments.edit', $assessment) }}"
                                                class="px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-semibold"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.assessments.destroy', $assessment) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus penilaian ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 text-sm font-semibold"
                                                >
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="px-5 py-12 text-center"
                                    >

                                        <div class="text-slate-400">

                                            <svg
                                                class="w-12 h-12 mx-auto mb-3"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
                                                />

                                            </svg>

                                            <p class="font-semibold">
                                                Belum ada penilaian.
                                            </p>

                                            <p class="text-sm mt-1">
                                                Silakan tambahkan penilaian guru.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


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