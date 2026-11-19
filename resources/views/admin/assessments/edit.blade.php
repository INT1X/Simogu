<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex items-center gap-3">

                    <div class="w-2 h-8 bg-blue-600 rounded-full"></div>

                    <div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Edit Penilaian Guru
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Perbarui hasil penilaian kinerja guru.
                        </p>

                    </div>

                </div>

            </div>

        </header>


        <section class="p-4 sm:p-6 lg:p-8">

            <div class="mb-6">

                <a
                    href="{{ route('admin.assessments.show', $assessment) }}"
                    class="text-sm font-semibold text-slate-600 hover:text-blue-600"
                >
                    ← Kembali ke Detail
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
                action="{{ route('admin.assessments.update', $assessment) }}"
            >

                @csrf

                @method('PUT')


                {{-- INFORMASI --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 mb-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Guru
                            </label>

                            <select
                                name="teacher_id"
                                required
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                @foreach($teachers as $teacher)

                                    <option
                                        value="{{ $teacher->id }}"
                                        {{ old('teacher_id', $assessment->teacher_id) == $teacher->id ? 'selected' : '' }}
                                    >

                                        {{ $teacher->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Pengawas
                            </label>

                            <select
                                name="supervisor_id"
                                required
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                @foreach($supervisors as $supervisor)

                                    <option
                                        value="{{ $supervisor->id }}"
                                        {{ old('supervisor_id', $assessment->supervisor_id) == $supervisor->id ? 'selected' : '' }}
                                    >

                                        {{ $supervisor->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                name="assessment_date"
                                value="{{ old('assessment_date', $assessment->assessment_date?->format('Y-m-d')) }}"
                                required
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>

                    </div>

                </div>


                {{-- INDIKATOR --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">

                    <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                        <h2 class="font-bold text-slate-800">
                            Nilai Indikator
                        </h2>

                    </div>


                    <div class="p-5 sm:p-6">

                        @php
                            $groupedIndicators = $indicators->groupBy('competency');
                        @endphp

                        @foreach($groupedIndicators as $competency => $competencyIndicators)

                            <div class="mb-6 border border-slate-200 rounded-2xl overflow-hidden">

                                <div class="px-5 py-4 bg-slate-50 border-b border-slate-200">

                                    <h3 class="font-bold text-slate-800">
                                        {{ $competency }}
                                    </h3>

                                </div>


                                @foreach($competencyIndicators as $indicator)

                                    <div class="p-5 border-b border-slate-100 last:border-b-0">

                                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">

                                            <div class="md:col-span-7">

                                                <div class="flex items-start gap-3">

                                                    <span class="px-2.5 py-1 rounded-lg bg-purple-100 text-purple-700 text-xs font-bold">

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


                                            <div class="md:col-span-2">

                                                <label class="block text-xs font-semibold text-slate-500 mb-2">
                                                    Nilai
                                                </label>

                                                <input
                                                    type="number"
                                                    name="scores[{{ $indicator->id }}]"
                                                    value="{{ old('scores.' . $indicator->id, $scores[$indicator->id] ?? '') }}"
                                                    min="0"
                                                    max="100"
                                                    step="0.01"
                                                    required
                                                    class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                                >

                                            </div>


                                            <div class="md:col-span-3">

                                                <label class="block text-xs font-semibold text-slate-500 mb-2">
                                                    Catatan
                                                </label>

                                                <textarea
                                                    name="notes[{{ $indicator->id }}]"
                                                    rows="2"
                                                    class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                                                >{{ old('notes.' . $indicator->id, $notes[$indicator->id] ?? '') }}</textarea>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @endforeach

                    </div>

                </div>


                {{-- DOKUMEN + STATUS --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6 mb-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>

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
                                value="{{ old('document_score', $assessment->document_score ?? 0) }}"
                                min="0"
                                max="100"
                                step="0.01"
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="status"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option
                                    value="draft"
                                    {{ old('status', $assessment->status) === 'draft' ? 'selected' : '' }}
                                >
                                    Draft
                                </option>

                                <option
                                    value="selesai"
                                    {{ old('status', $assessment->status) === 'selesai' ? 'selected' : '' }}
                                >
                                    Selesai
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- BUTTON --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                    <a
                        href="{{ route('admin.assessments.show', $assessment) }}"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </section>

    </main>

</body>

</html>