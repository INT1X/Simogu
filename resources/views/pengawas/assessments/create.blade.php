<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Penilaian Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100">

    @include('components.pengawas-sidebar')

    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                    <div>
                        <a href="{{ route('pengawas.assessments.index') }}"
                           class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 mb-2">
                            ← Kembali ke Penilaian
                        </a>

                        <h1 class="text-2xl font-bold text-slate-800">
                            Penilaian Kinerja Guru
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Berikan penilaian berdasarkan indikator yang telah ditetapkan administrator.
                        </p>
                    </div>

                    <div class="text-left sm:text-right">
                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-sm text-blue-600">Pengawas</p>
                    </div>

                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8 max-w-[1600px] mx-auto">

            {{-- FLASH ERROR --}}
            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                    <p class="font-bold text-red-700 text-sm">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            {{-- ERROR VALIDASI --}}
            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">
                    <p class="font-bold text-red-700 text-sm">
                        Terjadi kesalahan:
                    </p>

                    <ul class="mt-1 list-disc list-inside text-xs text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- INFORMASI GURU --}}
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-5">

                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-4 text-white">
                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-xl bg-white/15 border border-white/20
                                    flex items-center justify-center text-xl font-bold flex-shrink-0">
                            {{ strtoupper(substr($teacher->name ?? '-', 0, 1)) }}
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs text-blue-100">Guru yang Dinilai</p>

                            <h2 class="text-xl font-bold truncate">
                                {{ $teacher->name ?? '-' }}
                            </h2>

                            @if($teacher->nip)
                                <p class="text-xs text-blue-100 mt-0.5">
                                    NIP: {{ $teacher->nip }}
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="px-5 py-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                Sekolah
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $teacher->school->name ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                Mata Pelajaran
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $teacher->subject ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[10px] uppercase tracking-wider font-bold text-slate-400">
                                Pengawas
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $supervisor->name ?? '-' }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

            {{-- PERIODE PENILAIAN --}}
            @if(isset($assessmentPeriod) && $assessmentPeriod)
                <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                    <p class="text-sm text-blue-800">
                        Periode penilaian:
                        <strong>
                            {{ $assessmentPeriod->name
                                ?? $assessmentPeriod->nama
                                ?? $assessmentPeriod->year
                                ?? 'Periode aktif' }}
                        </strong>
                    </p>
                </div>
            @endif

            {{-- PERSIAPAN DATA --}}
            @php
                $groupedIndicators = $indicators->groupBy('competency');

                $competencyOrder = [
                    'Pedagogik',
                    'Kepribadian',
                    'Sosial',
                    'Profesional',
                ];

                $existingDetails = $assessment
                    ? $assessment->details->keyBy('indicator_id')
                    : collect();
            @endphp

            {{-- FORM PENILAIAN --}}
            <form method="POST"
                  action="{{ route('pengawas.assessments.store') }}"
                  id="assessmentForm">

                @csrf

                <input type="hidden"
                       name="teacher_id"
                       value="{{ $teacher->id }}">

                <input type="hidden"
                       name="action"
                       id="assessmentAction"
                       value="{{ old('action', 'draft') }}">

                {{-- TANGGAL PENILAIAN --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4 mb-5">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                        <label for="assessment_date"
                               class="text-sm font-bold text-slate-700">
                            Tanggal Penilaian
                            <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="date"
                            name="assessment_date"
                            id="assessment_date"
                            value="{{ old(
                                'assessment_date',
                                $assessment?->assessment_date
                                    ? \Illuminate\Support\Carbon::parse($assessment->assessment_date)->format('Y-m-d')
                                    : now()->format('Y-m-d')
                            ) }}"
                            required
                            class="w-full sm:w-52 rounded-lg border border-slate-300 px-3 py-2 text-sm
                                   focus:border-blue-500 focus:ring-2 focus:ring-blue-100
                                   @error('assessment_date') border-red-500 @enderror">

                        @error('assessment_date')
                            <p class="text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>
                </div>

                {{-- PETUNJUK --}}
                <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3">
                    <div class="flex items-start gap-3">

                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600
                                    flex items-center justify-center flex-shrink-0">

                            <svg class="w-4 h-4"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 110-20 10 10 0 010 20z" />
                            </svg>

                        </div>

                        <div>
                            <h3 class="font-bold text-blue-800 text-sm">
                                Petunjuk Penilaian
                            </h3>

                            <p class="text-xs text-blue-700 mt-0.5 leading-relaxed">
                                Berikan nilai pada setiap indikator dengan rentang
                                <strong>0–100</strong>. Indikator dan bobot mengikuti konfigurasi administrator.
                                <strong>Seluruh indikator wajib diisi</strong>, baik saat menyimpan draft maupun
                                menyelesaikan penilaian. Catatan indikator bersifat opsional.
                            </p>
                        </div>

                    </div>
                </div>

                {{-- GRID KOMPETENSI --}}
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                    @foreach($competencyOrder as $competency)

                        @php
                            $competencyIndicators = $groupedIndicators->get($competency, collect());
                            $competencyWeight = $weights->get($competency);
                        @endphp

                        @if($competencyIndicators->count())

                            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">

                                {{-- HEADER KOMPETENSI --}}
                                <div class="px-4 py-4 bg-slate-50 border-b border-slate-200">
                                    <div class="flex items-center justify-between gap-3">

                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2">

                                                <span class="w-2 h-2 rounded-full bg-blue-600 flex-shrink-0"></span>

                                                <h2 class="text-base font-bold text-slate-800">
                                                    {{ $competency }}
                                                </h2>

                                            </div>

                                            <p class="text-[11px] text-slate-500 mt-1 ml-4">
                                                {{ $competencyIndicators->count() }} indikator
                                            </p>
                                        </div>

                                        @if($competencyWeight)
                                            <div class="flex-shrink-0 text-center rounded-lg bg-blue-100 px-3 py-1.5">

                                                <p class="text-[9px] uppercase font-bold text-blue-500">
                                                    Bobot
                                                </p>

                                                <p class="text-base font-bold text-blue-700">
                                                    {{ number_format((float) $competencyWeight->weight, 0) }}%
                                                </p>

                                            </div>
                                        @endif

                                    </div>
                                </div>

                                {{-- DAFTAR INDIKATOR --}}
                                <div class="divide-y divide-slate-100 flex-1">

                                    @foreach($competencyIndicators as $indicator)

                                        @php
                                            $existingDetail = $existingDetails->get($indicator->id);

                                            $oldScore = old(
                                                "scores.{$indicator->id}",
                                                $existingDetail?->score
                                            );

                                            $oldNotes = old(
                                                "notes.{$indicator->id}",
                                                $existingDetail?->notes
                                            );
                                        @endphp

                                        <div class="p-4">

                                            <div class="flex items-start justify-between gap-3">

                                                {{-- INFORMASI INDIKATOR --}}
                                                <div class="flex-1 min-w-0">

                                                    <div class="flex items-center gap-2">

                                                        @if($indicator->code)
                                                            <span class="inline-flex px-2 py-1 rounded-md bg-blue-50
                                                                         text-blue-700 text-[9px] font-bold flex-shrink-0">
                                                                {{ $indicator->code }}
                                                            </span>
                                                        @endif

                                                        @if(isset($indicator->weight))
                                                            <span class="text-[10px] font-semibold text-slate-400">
                                                                Bobot {{ number_format((float) $indicator->weight, 0) }}%
                                                            </span>
                                                        @endif

                                                    </div>

                                                    <h3 class="mt-2 text-sm font-semibold text-slate-800 leading-snug">
                                                        {{ $indicator->name }}
                                                    </h3>

                                                    @if($indicator->description)
                                                        <p class="mt-1 text-[11px] text-slate-500 leading-relaxed">
                                                            {{ $indicator->description }}
                                                        </p>
                                                    @endif

                                                </div>

                                                {{-- INPUT NILAI --}}
                                                <div class="w-[76px] flex-shrink-0">

                                                    <label for="score_{{ $indicator->id }}"
                                                           class="block text-[10px] font-bold text-slate-500 text-center mb-1">
                                                        Nilai <span class="text-red-500">*</span>
                                                    </label>

                                                    <input
                                                        type="number"
                                                        name="scores[{{ $indicator->id }}]"
                                                        id="score_{{ $indicator->id }}"
                                                        value="{{ $oldScore }}"
                                                        min="0"
                                                        max="100"
                                                        step="0.01"
                                                        required
                                                        placeholder="0"
                                                        inputmode="decimal"
                                                        class="w-full rounded-lg border border-slate-300 px-2 py-2
                                                               text-center text-sm font-bold text-slate-800
                                                               focus:border-blue-500 focus:ring-1 focus:ring-blue-100
                                                               @error('scores.' . $indicator->id) border-red-500 @enderror">

                                                    @error('scores.' . $indicator->id)
                                                        <p class="text-[9px] text-red-600 mt-1">
                                                            {{ $message }}
                                                        </p>
                                                    @enderror

                                                </div>

                                            </div>

                                            {{-- CATATAN --}}
                                            <div class="mt-3">

                                                <label for="notes_{{ $indicator->id }}"
                                                       class="sr-only">
                                                    Catatan indikator {{ $indicator->name }}
                                                </label>

                                                <input
                                                    type="text"
                                                    name="notes[{{ $indicator->id }}]"
                                                    id="notes_{{ $indicator->id }}"
                                                    value="{{ $oldNotes }}"
                                                    maxlength="1000"
                                                    placeholder="Catatan pengawas (opsional)"
                                                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2
                                                           text-[11px] text-slate-700 placeholder:text-slate-400
                                                           focus:bg-white focus:border-blue-500 focus:ring-1 focus:ring-blue-100">

                                                @error('notes.' . $indicator->id)
                                                    <p class="text-[10px] text-red-600 mt-1">
                                                        {{ $message }}
                                                    </p>
                                                @enderror

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                                {{-- FOOTER KOMPETENSI --}}
                                <div class="px-4 py-2.5 bg-slate-50 border-t border-slate-100">
                                    <p class="text-[10px] text-slate-400">
                                        Nilai indikator: 0–100
                                    </p>
                                </div>

                            </div>

                        @endif

                    @endforeach

                </div>

                {{-- PERINGATAN JIKA INDIKATOR KOSONG --}}
                @if($indicators->isEmpty())
                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">
                        <p class="text-sm font-semibold text-amber-800">
                            Belum ada indikator aktif untuk penilaian.
                        </p>

                        <p class="text-xs text-amber-700 mt-1">
                            Silakan periksa konfigurasi indikator kepada administrator.
                        </p>
                    </div>
                @endif

                {{-- RINGKASAN BOBOT --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm px-5 py-4 mt-5 mb-5">

                    <div class="flex items-center justify-between mb-4">

                        <div>
                            <h2 class="text-sm font-bold text-slate-800">
                                Ringkasan Bobot Penilaian
                            </h2>

                            <p class="text-xs text-slate-500 mt-0.5">
                                Bobot diambil dari konfigurasi administrator.
                            </p>
                        </div>

                        <div class="hidden sm:block">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-slate-100
                                         text-xs font-semibold text-slate-600">
                                Total bobot target 100%
                            </span>
                        </div>

                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">

                        @foreach($weights as $weight)

                            <div class="rounded-lg border border-slate-200 bg-slate-50 px-3 py-3 text-center">

                                <p class="text-[10px] uppercase tracking-wide font-semibold text-slate-500">
                                    {{ $weight->competency }}
                                </p>

                                <p class="text-lg font-bold text-slate-800 mt-0.5">
                                    {{ number_format((float) $weight->weight, 0) }}%
                                </p>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pb-6">

                    <a href="{{ route('pengawas.assessments.index') }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg
                              border border-slate-300 bg-white text-slate-700 font-semibold
                              text-sm hover:bg-slate-50 transition">
                        Batal
                    </a>

                    {{-- SIMPAN DRAFT --}}
                    {{-- Tidak menggunakan formnovalidate --}}
                    <button
                        type="submit"
                        id="saveDraftButton"
                        data-action="draft"
                        class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg
                               border border-blue-200 bg-white text-blue-700 font-bold text-sm
                               hover:bg-blue-50 transition">

                        <svg class="w-4 h-4 mr-2"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7" />
                        </svg>

                        Simpan Draft
                    </button>

                    {{-- SELESAIKAN PENILAIAN --}}
                    <button
                        type="submit"
                        id="completeAssessmentButton"
                        data-action="complete"
                        class="inline-flex items-center justify-center px-6 py-2.5 rounded-lg
                               bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm
                               shadow-sm transition">

                        <svg class="w-4 h-4 mr-2"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7" />
                        </svg>

                        Selesaikan Penilaian
                    </button>

                </div>

            </form>

        </section>

    </main>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('assessmentForm');
            const actionInput = document.getElementById('assessmentAction');
            const draftButton = document.getElementById('saveDraftButton');
            const completeButton = document.getElementById('completeAssessmentButton');

            if (!form || !actionInput || !draftButton || !completeButton) {
                return;
            }

            let submitting = false;

            // FLASH SUCCESS
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    confirmButtonText: 'OK'
                });
            @endif

            // FLASH ERROR
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    confirmButtonText: 'OK'
                });
            @endif

            // ERROR VALIDASI
            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: @json(
                        '<ul style="text-align:left;padding-left:20px;">' .
                        implode('', array_map(
                            fn ($error) => '<li>' . e($error) . '</li>',
                            $errors->all()
                        )) .
                        '</ul>'
                    ),
                    confirmButtonText: 'Periksa Kembali'
                });
            @endif

            /*
             * SIMPAN DRAFT
             *
             * Semua indikator wajib terisi.
             * Validasi browser dan server tetap berlaku.
             */
            draftButton.addEventListener('click', function () {
                actionInput.value = 'draft';
            });

            /*
             * SELESAIKAN PENILAIAN
             *
             * Memeriksa validitas semua input terlebih dahulu.
             * Jika valid, pengguna diminta mengonfirmasi.
             */
            completeButton.addEventListener('click', async function (event) {

                event.preventDefault();

                if (submitting) {
                    return;
                }

                actionInput.value = 'complete';

                // Periksa seluruh input wajib sebelum menampilkan konfirmasi.
                if (!form.reportValidity()) {
                    return;
                }

                const result = await Swal.fire({
                    icon: 'warning',
                    title: 'Selesaikan Penilaian?',
                    text: 'Pastikan semua nilai indikator sudah benar. Penilaian akan disimpan dengan status selesai.',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Selesaikan',
                    cancelButtonText: 'Periksa Kembali',
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    reverseButtons: true
                });

                if (!result.isConfirmed) {
                    actionInput.value = 'draft';
                    return;
                }

                submitting = true;

                draftButton.disabled = true;
                completeButton.disabled = true;

                draftButton.classList.add('opacity-60', 'cursor-not-allowed');
                completeButton.classList.add('opacity-60', 'cursor-not-allowed');

                /*
                 * Mengirim form dengan action=complete.
                 * form.submit() tidak memicu event submit kembali.
                 */
                form.submit();
            });

            /*
             * PENANGANAN SUBMIT FORM
             *
             * Menetapkan action sesuai tombol yang digunakan.
             * Mencegah pengiriman berulang melalui tombol draft.
             */
            form.addEventListener('submit', function (event) {

                if (submitting) {
                    event.preventDefault();
                    return;
                }

                const submitter = event.submitter;

                if (submitter === draftButton) {
                    actionInput.value = 'draft';
                } else if (submitter === completeButton) {
                    actionInput.value = 'complete';
                }

                if (submitter === draftButton) {

                    submitting = true;

                    draftButton.disabled = true;
                    completeButton.disabled = true;

                    draftButton.classList.add('opacity-60', 'cursor-not-allowed');
                    completeButton.classList.add('opacity-60', 'cursor-not-allowed');
                }

            });

        });
    </script>

</body>

</html>
