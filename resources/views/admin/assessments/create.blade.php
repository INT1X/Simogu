<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex items-center gap-3">

                    <div class="w-2 h-8 bg-purple-600 rounded-full"></div>

                    <div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Tambah Penilaian Guru
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Masukkan penilaian berdasarkan indikator kinerja guru.
                        </p>

                    </div>

                </div>

            </div>

        </header>


        <section class="p-4 sm:p-6 lg:p-8">

            <div class="mb-6">

                <a
                    href="{{ route('admin.assessments.index') }}"
                    class="text-sm font-semibold text-slate-600 hover:text-purple-600"
                >
                    ← Kembali ke Penilaian
                </a>

            </div>


            @if($errors->any())

                <div class="mb-6 p-5 rounded-2xl bg-red-50 border border-red-200 text-red-800">

                    <p class="font-bold">
                        Terdapat kesalahan:
                    </p>

                    <ul class="list-disc list-inside mt-2 text-sm">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('admin.assessments.store') }}"
            >

                @csrf


                {{-- DATA PENILAIAN --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

                    <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                        <h2 class="font-bold text-slate-800">
                            Informasi Penilaian
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Tentukan guru, pengawas dan tanggal penilaian.
                        </p>

                    </div>


                    <div class="p-5 sm:p-6">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">


                            {{-- GURU --}}
                            <div>

                                <label
                                    for="teacher_id"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Guru <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="teacher_id"
                                    name="teacher_id"
                                    required
                                    class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                                >

                                    <option value="">
                                        -- Pilih Guru --
                                    </option>

                                    @foreach($teachers as $teacher)

                                        <option
                                            value="{{ $teacher->id }}"
                                            {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}
                                        >

                                            {{ $teacher->name }}

                                            @if($teacher->nip)
                                                - {{ $teacher->nip }}
                                            @endif

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- PENGAWAS --}}
                            <div>

                                <label
                                    for="supervisor_id"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Pengawas <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="supervisor_id"
                                    name="supervisor_id"
                                    required
                                    class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                                >

                                    <option value="">
                                        -- Pilih Pengawas --
                                    </option>

                                    @foreach($supervisors as $supervisor)

                                        <option
                                            value="{{ $supervisor->id }}"
                                            {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}
                                        >

                                            {{ $supervisor->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- TANGGAL --}}
                            <div>

                                <label
                                    for="assessment_date"
                                    class="block text-sm font-semibold text-slate-700 mb-2"
                                >
                                    Tanggal Penilaian
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="assessment_date"
                                    name="assessment_date"
                                    value="{{ old('assessment_date', now()->format('Y-m-d')) }}"
                                    required
                                    class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                                >

                            </div>

                        </div>

                    </div>

                </div>


                {{-- INDIKATOR --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

                    <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                        <h2 class="font-bold text-slate-800">
                            Indikator Penilaian
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Berikan nilai 0 sampai 100 untuk setiap indikator.
                        </p>

                    </div>


                    <div class="p-5 sm:p-6 space-y-6">

                        @php
                            $groupedIndicators = $indicators->groupBy('competency');
                        @endphp


                        @foreach($groupedIndicators as $competency => $competencyIndicators)

                            <div class="border border-slate-200 rounded-2xl overflow-hidden">

                                <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">

                                    <h3 class="font-bold text-slate-800">
                                        {{ $competency }}
                                    </h3>

                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ $competencyIndicators->count() }} indikator
                                    </p>

                                </div>


                                <div class="divide-y divide-slate-100">

                                    @foreach($competencyIndicators as $indicator)

                                        <div class="p-5">

                                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start">


                                                {{-- INDIKATOR --}}
                                                <div class="lg:col-span-7">

                                                    <div class="flex items-start gap-3">

                                                        <span class="inline-flex px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700 text-xs font-bold shrink-0">

                                                            {{ $indicator->code }}

                                                        </span>

                                                        <div>

                                                            <p class="font-semibold text-slate-800">

                                                                {{ $indicator->name }}

                                                            </p>

                                                            @if($indicator->description)

                                                                <p class="text-sm text-slate-500 mt-1">

                                                                    {{ $indicator->description }}

                                                                </p>

                                                            @endif

                                                        </div>

                                                    </div>

                                                </div>


                                                {{-- NILAI --}}
                                                <div class="lg:col-span-2">

                                                    <label
                                                        class="block text-xs font-semibold text-slate-500 mb-2"
                                                    >
                                                        Nilai
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="scores[{{ $indicator->id }}]"
                                                        value="{{ old('scores.' . $indicator->id) }}"
                                                        min="0"
                                                        max="100"
                                                        step="0.01"
                                                        required
                                                        placeholder="0-100"
                                                        class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                                                    >

                                                </div>


                                                {{-- CATATAN --}}
                                                <div class="lg:col-span-3">

                                                    <label
                                                        class="block text-xs font-semibold text-slate-500 mb-2"
                                                    >
                                                        Catatan
                                                    </label>

                                                    <textarea
                                                        name="notes[{{ $indicator->id }}]"
                                                        rows="2"
                                                        placeholder="Catatan pengawas..."
                                                        class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                                                    >{{ old('notes.' . $indicator->id) }}</textarea>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- DOKUMEN --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

                    <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                        <h2 class="font-bold text-slate-800">
                            Nilai Dokumen
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Nilai tambahan dari dokumen pendukung guru.
                        </p>

                    </div>


                    <div class="p-5 sm:p-6">

                        <div class="max-w-md">

                            <label
                                for="document_score"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Nilai Dokumen
                            </label>

                            <input
                                type="number"
                                id="document_score"
                                name="document_score"
                                value="{{ old('document_score', 0) }}"
                                min="0"
                                max="100"
                                step="0.01"
                                class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                            >

                            <p class="text-xs text-slate-400 mt-2">
                                Untuk tahap awal, nilai dokumen dimasukkan dalam skala 0-100.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- STATUS --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 mb-6">

                    <label
                        for="status"
                        class="block text-sm font-semibold text-slate-700 mb-2"
                    >
                        Status Penilaian
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="max-w-md w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500"
                    >

                        <option
                            value="draft"
                            {{ old('status') === 'draft' ? 'selected' : '' }}
                        >
                            Draft
                        </option>

                        <option
                            value="selesai"
                            {{ old('status', 'selesai') === 'selesai' ? 'selected' : '' }}
                        >
                            Selesai
                        </option>

                    </select>

                </div>


                {{-- BUTTON --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                    <a
                        href="{{ route('admin.assessments.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold shadow-sm"
                    >
                        Simpan Penilaian
                    </button>

                </div>

            </form>

        </section>

    </main>

</body>

</html>