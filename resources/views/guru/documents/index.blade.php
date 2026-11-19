<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dokumen Saya - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body class="bg-slate-100">

    @php
        $allDocuments = $documents;

        $activeDocuments = $activePeriod
            ? $allDocuments->filter(
                fn ($document) =>
                    (int) $document->assessment_period_id === (int) $activePeriod->id
            )
            : collect();

        $historyDocuments = $allDocuments->reject(
            fn ($document) =>
                $activePeriod &&
                (int) $document->assessment_period_id === (int) $activePeriod->id
        );

        $showHistoryInitially = $selectedPeriod
            && (
                !$activePeriod ||
                (int) $selectedPeriod->id !== (int) $activePeriod->id
            );

        $totalDocuments = (int) ($statistics->total ?? 0);
        $pendingDocuments = (int) ($statistics->pending ?? 0);
        $verifiedDocuments = (int) ($statistics->verified ?? 0);
        $rejectedDocuments = (int) ($statistics->rejected ?? 0);
    @endphp

    <div class="min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.guru-sidebar')

        {{-- AREA UTAMA --}}
        <div class="md:ml-72 min-h-screen">

            {{-- HEADER --}}
            <header class="sticky top-0 z-30 bg-white border-b border-slate-200">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center justify-between gap-4">

                        <div class="flex items-center gap-3">

                            <button
                                id="guruSidebarToggle"
                                type="button"
                                aria-label="Buka menu"
                                class="md:hidden w-10 h-10 rounded-lg bg-slate-900
                                       text-white flex items-center justify-center
                                       hover:bg-slate-800">

                                <i class="fa-solid fa-bars"></i>
                            </button>

                            <div>
                                <h1 class="text-xl sm:text-2xl font-bold text-slate-800">
                                    Dokumen Saya
                                </h1>

                                <p class="text-sm text-slate-500">
                                    Kelola dokumen pendukung penilaian Anda
                                </p>
                            </div>

                        </div>

                        <div class="hidden sm:flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100
                                        text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-folder-open"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="p-4 sm:p-6 lg:p-8">

                {{-- PESAN SUKSES --}}
                @if (session('success'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border
                                border-emerald-200 bg-emerald-50 p-4 text-emerald-800"
                         role="status">

                        <i class="fa-solid fa-circle-check mt-0.5"></i>

                        <p class="text-sm font-medium">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                {{-- PESAN ERROR --}}
                @if (session('error'))
                    <div class="mb-5 flex items-start gap-3 rounded-xl border
                                border-red-200 bg-red-50 p-4 text-red-800"
                         role="alert">

                        <i class="fa-solid fa-circle-exclamation mt-0.5"></i>

                        <p class="text-sm font-medium">
                            {{ session('error') }}
                        </p>
                    </div>
                @endif

                {{-- WELCOME --}}
                <div class="mb-6 rounded-2xl bg-gradient-to-r from-blue-600
                            to-indigo-600 p-6 text-white shadow-lg sm:p-8">

                    <div class="flex flex-col gap-6 md:flex-row
                                md:items-center md:justify-between">

                        <div>
                            <p class="mb-1 text-sm text-blue-100">
                                Dokumen Guru
                            </p>

                            <h2 class="text-2xl font-bold sm:text-3xl">
                                {{ $teacher->name }}
                            </h2>

                            <p class="mt-2 max-w-2xl text-blue-100">
                                Upload dan kelola dokumen pendukung penilaian
                                kinerja Anda, termasuk melihat riwayat dokumen
                                dari periode sebelumnya.
                            </p>

                            @if ($activePeriod)
                                <div class="mt-4 inline-flex items-center gap-2
                                            rounded-lg bg-white/15 px-3 py-2 text-sm">

                                    <i class="fa-solid fa-calendar-check"></i>

                                    <span>
                                        Periode aktif:
                                        <strong>
                                            {{ $activePeriod->name }}
                                        </strong>
                                    </span>
                                </div>
                            @else
                                <div class="mt-4 inline-flex items-center gap-2
                                            rounded-lg bg-amber-400/20 px-3 py-2 text-sm">

                                    <i class="fa-solid fa-triangle-exclamation"></i>

                                    <span>
                                        Belum ada periode penilaian aktif.
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="shrink-0">
                            <button
                                type="button"
                                id="openUploadModal"
                                class="inline-flex items-center gap-2 rounded-xl
                                       bg-white px-5 py-3 font-semibold text-blue-600
                                       shadow-sm transition hover:bg-blue-50
                                       disabled:cursor-not-allowed disabled:opacity-60"
                                @disabled(!$activePeriod || $documentTypes->isEmpty())>

                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                Upload Dokumen
                            </button>

                            @if (!$activePeriod)
                                <p class="mt-2 text-xs text-blue-100">
                                    Upload tersedia setelah periode diaktifkan.
                                </p>
                            @elseif ($documentTypes->isEmpty())
                                <p class="mt-2 text-xs text-blue-100">
                                    Belum ada jenis dokumen yang aktif.
                                </p>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- STATISTIK SELURUH DOKUMEN --}}
                <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2
                            xl:grid-cols-4">

                    {{-- Total --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Total Dokumen
                                </p>

                                <p class="mt-1 text-3xl font-bold text-slate-800">
                                    {{ $totalDocuments }}
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center
                                        rounded-xl bg-blue-100 text-blue-600">
                                <i class="fa-solid fa-folder-open text-xl"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Pending --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Menunggu Verifikasi
                                </p>

                                <p class="mt-1 text-3xl font-bold text-slate-800">
                                    {{ $pendingDocuments }}
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center
                                        rounded-xl bg-amber-100 text-amber-600">
                                <i class="fa-solid fa-clock text-xl"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Verified --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Terverifikasi
                                </p>

                                <p class="mt-1 text-3xl font-bold text-slate-800">
                                    {{ $verifiedDocuments }}
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center
                                        rounded-xl bg-emerald-100 text-emerald-600">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Rejected --}}
                    <div class="rounded-2xl border border-slate-200
                                bg-white p-5 shadow-sm">

                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Ditolak
                                </p>

                                <p class="mt-1 text-3xl font-bold text-slate-800">
                                    {{ $rejectedDocuments }}
                                </p>
                            </div>

                            <div class="flex h-12 w-12 items-center justify-center
                                        rounded-xl bg-red-100 text-red-600">
                                <i class="fa-solid fa-circle-xmark text-xl"></i>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- FILTER --}}
                <div class="mb-6 rounded-2xl border border-slate-200
                            bg-white p-5 shadow-sm sm:p-6">

                    <div class="mb-4">
                        <h3 class="font-bold text-slate-800">
                            <i class="fa-solid fa-filter mr-2 text-blue-600"></i>
                            Filter Dokumen
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Pilih periode atau status untuk menyaring daftar dokumen.
                            Statistik di atas tetap menghitung semua dokumen Anda.
                        </p>
                    </div>

                    <form action="{{ route('guru.documents.index') }}"
                          method="GET"
                          class="grid grid-cols-1 items-end gap-4 md:grid-cols-3">

                        <div>
                            <label for="period"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Periode Penilaian
                            </label>

                            <select
                                id="period"
                                name="period"
                                class="w-full rounded-xl border border-slate-300
                                       bg-white px-4 py-3 focus:border-blue-500
                                       focus:ring-blue-500">

                                <option value="">Semua periode</option>

                                @foreach ($periods as $period)
                                    <option
                                        value="{{ $period->id }}"
                                        @selected((string) $selectedPeriodId === (string) $period->id)>

                                        {{ $period->name }}

                                        @if ($period->status === 'active')
                                            (Aktif)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status"
                                   class="mb-2 block text-sm font-semibold text-slate-700">
                                Status Dokumen
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="w-full rounded-xl border border-slate-300
                                       bg-white px-4 py-3 focus:border-blue-500
                                       focus:ring-blue-500">

                                <option value="">Semua status</option>

                                <option value="pending"
                                    @selected($status === 'pending')>
                                    Menunggu Verifikasi
                                </option>

                                <option value="verified"
                                    @selected($status === 'verified')>
                                    Terverifikasi
                                </option>

                                <option value="rejected"
                                    @selected($status === 'rejected')>
                                    Ditolak
                                </option>
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-2">
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2
                                       rounded-xl bg-blue-600 px-5 py-3
                                       font-semibold text-white hover:bg-blue-700">

                                <i class="fa-solid fa-magnifying-glass"></i>
                                Terapkan
                            </button>

                            <a
                                href="{{ route('guru.documents.index') }}"
                                class="inline-flex items-center justify-center gap-2
                                       rounded-xl bg-slate-100 px-5 py-3
                                       font-semibold text-slate-700 hover:bg-slate-200">

                                <i class="fa-solid fa-rotate-left"></i>
                                Reset
                            </a>
                        </div>

                    </form>
                </div>

                {{-- DAFTAR DOKUMEN PERIODE AKTIF --}}
                <section class="mb-6 overflow-hidden rounded-2xl
                                border border-slate-200 bg-white shadow-sm">

                    <div class="flex flex-col gap-3 border-b border-slate-200
                                px-5 py-5 sm:flex-row sm:items-center
                                sm:justify-between sm:px-6">

                        <div>
                            <h3 class="text-lg font-bold text-slate-800">
                                <i class="fa-solid fa-folder-open mr-2 text-blue-600"></i>
                                Dokumen Periode Aktif
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Dokumen untuk periode penilaian yang sedang berjalan.
                            </p>
                        </div>

                        <span class="inline-flex w-fit items-center rounded-full
                                     bg-blue-50 px-3 py-1.5 text-sm font-semibold
                                     text-blue-700">

                            {{ $activeDocuments->count() }} dokumen
                        </span>
                    </div>

                    @if (!$activePeriod)

                        <div class="px-6 py-10 text-center">
                            <i class="fa-solid fa-calendar-xmark text-3xl text-slate-300"></i>

                            <p class="mt-3 font-semibold text-slate-700">
                                Belum ada periode aktif
                            </p>

                            <p class="mt-1 text-sm text-slate-500">
                                Dokumen lama tetap dapat dilihat melalui bagian riwayat.
                            </p>
                        </div>

                    @elseif ($activeDocuments->isEmpty())

                        <div class="px-6 py-10 text-center">
                            <div class="mx-auto flex h-16 w-16 items-center
                                        justify-center rounded-2xl bg-slate-100
                                        text-slate-400">

                                <i class="fa-solid fa-folder-open text-2xl"></i>
                            </div>

                            <h4 class="mt-4 font-bold text-slate-800">
                                Belum Ada Dokumen pada Periode Aktif
                            </h4>

                            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                                Dokumen yang Anda unggah pada periode ini akan
                                ditampilkan di sini.
                            </p>

                            @if (!$selectedPeriod && !$status && $activePeriod)
                                <button
                                    type="button"
                                    id="openUploadModalEmpty"
                                    class="mt-5 inline-flex items-center gap-2
                                           rounded-xl bg-blue-600 px-5 py-3
                                           font-semibold text-white hover:bg-blue-700"
                                    @disabled($documentTypes->isEmpty())>

                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    Upload Dokumen
                                </button>
                            @endif
                        </div>

                    @else

                        <div class="divide-y divide-slate-100">

                            @foreach ($activeDocuments as $document)

                                <article class="p-5 transition hover:bg-slate-50 sm:p-6">

                                    <div class="flex flex-col gap-4 lg:flex-row
                                                lg:items-center lg:justify-between">

                                        <div class="flex min-w-0 items-start gap-4">

                                            <div class="flex h-12 w-12 shrink-0
                                                        items-center justify-center
                                                        rounded-xl bg-blue-100 text-blue-600">

                                                <i class="fa-solid fa-file-lines text-xl"></i>
                                            </div>

                                            <div class="min-w-0">
                                                <h4 class="break-words font-semibold text-slate-800">
                                                    {{ $document->title }}
                                                </h4>

                                                <p class="mt-1 text-sm text-slate-500">
                                                    <i class="fa-solid fa-tag mr-1"></i>
                                                    {{ $document->documentType->name ?? 'Tanpa jenis' }}
                                                </p>

                                                @if ($document->original_name)
                                                    <p class="mt-2 break-all text-xs text-slate-400">
                                                        <i class="fa-solid fa-paperclip mr-1"></i>
                                                        {{ $document->original_name }}
                                                    </p>
                                                @endif

                                                <p class="mt-2 text-xs text-slate-500">
                                                    <i class="fa-solid fa-calendar mr-1"></i>
                                                    Periode:
                                                    {{ $document->assessmentPeriod->name ?? 'Periode tidak diketahui' }}
                                                </p>

                                                @if ($document->created_at)
                                                    <p class="mt-1 text-xs text-slate-400">
                                                        Diunggah:
                                                        {{ $document->created_at->format('d/m/Y H:i') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3">

                                            @if ($document->status === 'verified')

                                                <span class="inline-flex items-center gap-1.5
                                                             rounded-full bg-emerald-100
                                                             px-3 py-1.5 text-xs font-semibold
                                                             text-emerald-700">
                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Terverifikasi
                                                </span>

                                            @elseif ($document->status === 'rejected')

                                                <span class="inline-flex items-center gap-1.5
                                                             rounded-full bg-red-100
                                                             px-3 py-1.5 text-xs font-semibold
                                                             text-red-700">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                    Ditolak
                                                </span>

                                            @else

                                                <span class="inline-flex items-center gap-1.5
                                                             rounded-full bg-amber-100
                                                             px-3 py-1.5 text-xs font-semibold
                                                             text-amber-700">
                                                    <i class="fa-solid fa-clock"></i>
                                                    Menunggu Verifikasi
                                                </span>

                                            @endif

                                            <span class="inline-flex items-center gap-2 rounded-lg
                                                         bg-slate-100 px-3 py-2 text-xs
                                                         font-semibold text-slate-600">

                                                <i class="fa-solid fa-file"></i>
                                                {{ $document->file_size
                                                    ? number_format($document->file_size / 1048576, 2) . ' MB'
                                                    : 'Ukuran tidak tersedia' }}
                                            </span>

                                        </div>
                                    </div>

                                </article>

                            @endforeach

                        </div>

                    @endif
                </section>

                {{-- RIWAYAT DOKUMEN --}}
                <section class="overflow-hidden rounded-2xl border
                                border-slate-200 bg-white shadow-sm">

                    <div class="flex flex-col gap-4 px-5 py-5 sm:px-6">

                        <div class="flex flex-col gap-3 sm:flex-row
                                    sm:items-center sm:justify-between">

                            <div>
                                <h3 class="text-lg font-bold text-slate-800">
                                    <i class="fa-solid fa-clock-rotate-left mr-2 text-indigo-600"></i>
                                    Riwayat Dokumen
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Dokumen dari periode sebelumnya atau dokumen
                                    yang belum memiliki periode.
                                </p>
                            </div>

                            <button
                                type="button"
                                id="toggleHistory"
                                aria-controls="historyContent"
                                aria-expanded="{{ $showHistoryInitially ? 'true' : 'false' }}"
                                class="inline-flex w-fit items-center justify-center gap-2
                                       rounded-xl bg-slate-100 px-4 py-2.5
                                       text-sm font-semibold text-slate-700
                                       transition hover:bg-slate-200">

                                <i id="historyToggleIcon"
                                   class="fa-solid {{ $showHistoryInitially ? 'fa-eye-slash' : 'fa-eye' }}"></i>

                                <span id="historyToggleText">
                                    {{ $showHistoryInitially ? 'Sembunyikan Riwayat' : 'Lihat Riwayat Dokumen' }}
                                </span>
                            </button>

                        </div>

                        <div class="flex flex-wrap gap-2 text-sm">

                            <span class="rounded-full bg-slate-100 px-3 py-1.5 text-slate-600">
                                {{ $historyDocuments->count() }} dokumen riwayat
                            </span>

                            @if ($selectedPeriod)
                                <span class="rounded-full bg-indigo-50 px-3 py-1.5 text-indigo-700">
                                    Filter: {{ $selectedPeriod->name }}
                                </span>
                            @endif

                            @if ($status)
                                <span class="rounded-full bg-blue-50 px-3 py-1.5 text-blue-700">
                                    Status:
                                    @if ($status === 'pending')
                                        Menunggu Verifikasi
                                    @elseif ($status === 'verified')
                                        Terverifikasi
                                    @else
                                        Ditolak
                                    @endif
                                </span>
                            @endif

                        </div>
                    </div>

                    <div
                        id="historyContent"
                        class="{{ $showHistoryInitially ? '' : 'hidden' }} border-t border-slate-200">

                        @if ($historyDocuments->isEmpty())

                            <div class="px-6 py-12 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center
                                            justify-center rounded-2xl bg-slate-100
                                            text-slate-400">

                                    <i class="fa-solid fa-box-open text-2xl"></i>
                                </div>

                                <h4 class="mt-4 font-bold text-slate-800">
                                    Belum Ada Riwayat Dokumen
                                </h4>

                                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                                    Dokumen dari periode sebelumnya akan muncul di bagian ini.
                                </p>
                            </div>

                        @else

                            <div class="divide-y divide-slate-100">

                                @foreach ($historyDocuments as $document)

                                    <article class="p-5 transition hover:bg-slate-50 sm:p-6">

                                        <div class="flex flex-col gap-4 lg:flex-row
                                                    lg:items-center lg:justify-between">

                                            <div class="flex min-w-0 items-start gap-4">

                                                <div class="flex h-12 w-12 shrink-0
                                                            items-center justify-center
                                                            rounded-xl bg-indigo-100 text-indigo-600">

                                                    <i class="fa-solid fa-file-lines text-xl"></i>
                                                </div>

                                                <div class="min-w-0">

                                                    <h4 class="break-words font-semibold text-slate-800">
                                                        {{ $document->title }}
                                                    </h4>

                                                    <p class="mt-1 text-sm text-slate-500">
                                                        <i class="fa-solid fa-tag mr-1"></i>
                                                        {{ $document->documentType->name ?? 'Tanpa jenis' }}
                                                    </p>

                                                    @if ($document->original_name)
                                                        <p class="mt-2 break-all text-xs text-slate-400">
                                                            <i class="fa-solid fa-paperclip mr-1"></i>
                                                            {{ $document->original_name }}
                                                        </p>
                                                    @endif

                                                    <p class="mt-2 text-xs text-slate-500">
                                                        <i class="fa-solid fa-calendar mr-1"></i>
                                                        Periode:
                                                        {{ $document->assessmentPeriod->name ?? 'Periode tidak diketahui' }}
                                                    </p>

                                                    @if ($document->created_at)
                                                        <p class="mt-1 text-xs text-slate-400">
                                                            Diunggah:
                                                            {{ $document->created_at->format('d/m/Y H:i') }}
                                                        </p>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="flex flex-wrap items-center gap-3">

                                                @if ($document->status === 'verified')

                                                    <span class="inline-flex items-center gap-1.5
                                                                 rounded-full bg-emerald-100
                                                                 px-3 py-1.5 text-xs font-semibold
                                                                 text-emerald-700">
                                                        <i class="fa-solid fa-circle-check"></i>
                                                        Terverifikasi
                                                    </span>

                                                @elseif ($document->status === 'rejected')

                                                    <span class="inline-flex items-center gap-1.5
                                                                 rounded-full bg-red-100
                                                                 px-3 py-1.5 text-xs font-semibold
                                                                 text-red-700">
                                                        <i class="fa-solid fa-circle-xmark"></i>
                                                        Ditolak
                                                    </span>

                                                @else

                                                    <span class="inline-flex items-center gap-1.5
                                                                 rounded-full bg-amber-100
                                                                 px-3 py-1.5 text-xs font-semibold
                                                                 text-amber-700">
                                                        <i class="fa-solid fa-clock"></i>
                                                        Menunggu Verifikasi
                                                    </span>

                                                @endif

                                                <span class="inline-flex items-center gap-2 rounded-lg
                                                             bg-slate-100 px-3 py-2 text-xs
                                                             font-semibold text-slate-600">

                                                    <i class="fa-solid fa-file"></i>
                                                    {{ $document->file_size
                                                        ? number_format($document->file_size / 1048576, 2) . ' MB'
                                                        : 'Ukuran tidak tersedia' }}
                                                </span>

                                            </div>
                                        </div>

                                    </article>

                                @endforeach

                            </div>

                        @endif
                    </div>
                </section>

            </main>
        </div>
    </div>

    {{-- MODAL UPLOAD DOKUMEN --}}
    <div
        id="uploadDocumentModal"
        class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-50 overflow-y-auto"
        role="dialog"
        aria-modal="true"
        aria-labelledby="uploadModalTitle">

        <div class="flex min-h-screen items-center justify-center px-4 py-8">

            {{-- Overlay --}}
            <div
                class="fixed inset-0 bg-black/50"
                data-close-upload-modal>
            </div>

            {{-- Modal --}}
            <div class="relative z-10 w-full max-w-lg rounded-2xl
                        bg-white p-6 shadow-xl">

                <div class="mb-6 flex items-center justify-between">

                    <div>
                        <h2 id="uploadModalTitle"
                            class="text-xl font-bold text-slate-800">
                            Upload Dokumen
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Upload dokumen pendukung penilaian Anda.
                        </p>

                        @if ($activePeriod)
                            <p class="mt-2 text-xs font-medium text-blue-600">
                                Periode: {{ $activePeriod->name }}
                            </p>
                        @endif
                    </div>

                    <button
                        type="button"
                        data-close-upload-modal
                        aria-label="Tutup modal"
                        class="flex h-9 w-9 items-center justify-center
                               rounded-lg bg-slate-100 text-slate-500
                               hover:bg-slate-200">

                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Error Validasi --}}
                @if ($errors->any())

                    <div class="mb-5 rounded-xl border border-red-200
                                bg-red-50 p-4">

                        <p class="mb-2 font-semibold text-red-700">
                            Upload gagal:
                        </p>

                        <ul class="list-inside list-disc space-y-1 text-sm text-red-600">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>
                    </div>

                @endif

                @if (!$activePeriod)

                    <div class="rounded-xl border border-amber-200
                                bg-amber-50 p-4 text-sm text-amber-800">

                        Tidak ada periode penilaian aktif. Anda belum dapat
                        mengunggah dokumen baru.
                    </div>

                @elseif ($documentTypes->isEmpty())

                    <div class="rounded-xl border border-amber-200
                                bg-amber-50 p-4 text-sm text-amber-800">

                        Belum ada jenis dokumen aktif. Silakan hubungi administrator.
                    </div>

                @else

                    <form
                        action="{{ route('guru.documents.store') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        {{-- Jenis Dokumen --}}
                        <div class="mb-5">

                            <label
                                for="document_type_id"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Jenis Dokumen
                            </label>

                            <select
                                id="document_type_id"
                                name="document_type_id"
                                required
                                class="w-full rounded-xl border border-slate-300
                                       px-4 py-3 focus:border-blue-500
                                       focus:ring-blue-500">

                                <option value="">
                                    -- Pilih Jenis Dokumen --
                                </option>

                                @foreach ($documentTypes as $type)
                                    <option
                                        value="{{ $type->id }}"
                                        @selected(old('document_type_id') == $type->id)>

                                        {{ $type->name }}
                                    </option>
                                @endforeach

                            </select>

                        </div>

                        {{-- Judul --}}
                        <div class="mb-5">

                            <label
                                for="title"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                Judul Dokumen
                            </label>

                            <input
                                type="text"
                                id="title"
                                name="title"
                                value="{{ old('title') }}"
                                required
                                maxlength="255"
                                placeholder="Contoh: Sertifikat Pelatihan"
                                class="w-full rounded-xl border border-slate-300
                                       px-4 py-3 focus:border-blue-500
                                       focus:ring-blue-500">

                        </div>

                        {{-- File --}}
                        <div class="mb-6">

                            <label
                                for="file"
                                class="mb-2 block text-sm font-semibold text-slate-700">

                                File Dokumen
                            </label>

                            <input
                                type="file"
                                id="file"
                                name="file"
                                required
                                accept=".pdf,.doc,.docx"
                                class="w-full rounded-xl border border-slate-300
                                       bg-white px-4 py-3 text-sm">

                            <p class="mt-2 text-xs text-slate-500">
                                Format: PDF, DOC, DOCX. Maksimal 10 MB.
                            </p>

                        </div>

                        {{-- Tombol --}}
                        <div class="flex justify-end gap-3">

                            <button
                                type="button"
                                data-close-upload-modal
                                class="rounded-xl bg-slate-100 px-4 py-2.5
                                       font-semibold text-slate-700 hover:bg-slate-200">

                                Batal
                            </button>

                            <button
                                type="submit"
                                class="rounded-xl bg-blue-600 px-5 py-2.5
                                       font-semibold text-white hover:bg-blue-700">

                                <i class="fa-solid fa-cloud-arrow-up mr-2"></i>
                                Upload
                            </button>

                        </div>

                    </form>

                @endif
            </div>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar
            const sidebar = document.getElementById('guru-sidebar');
            const sidebarOverlay = document.getElementById('guru-sidebar-overlay');
            const sidebarToggle = document.getElementById('guruSidebarToggle');

            function openSidebar() {
                if (!sidebar || !sidebarOverlay) return;

                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
            }

            function closeSidebar() {
                if (!sidebar || !sidebarOverlay) return;

                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }

            sidebarToggle?.addEventListener('click', function () {
                if (!sidebar) return;

                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            sidebarOverlay?.addEventListener('click', closeSidebar);

            // Modal upload
            const uploadModal = document.getElementById('uploadDocumentModal');
            const openUploadButtons = [
                document.getElementById('openUploadModal'),
                document.getElementById('openUploadModalEmpty')
            ].filter(Boolean);

            function openUploadModal() {
                if (!uploadModal) return;

                uploadModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');

                const firstInput = uploadModal.querySelector(
                    'select, input:not([type="hidden"])'
                );

                firstInput?.focus();
            }

            function closeUploadModal() {
                if (!uploadModal) return;

                uploadModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openUploadButtons.forEach(function (button) {
                button.addEventListener('click', openUploadModal);
            });

            document.querySelectorAll('[data-close-upload-modal]')
                .forEach(function (element) {
                    element.addEventListener('click', closeUploadModal);
                });

            // Buka kembali modal jika ada error validasi.
            const hasValidationErrors = {{ $errors->any() ? 'true' : 'false' }};

            if (hasValidationErrors) {
                openUploadModal();
            }

            // Tutup modal dengan tombol Escape.
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeUploadModal();
                    closeSidebar();
                }
            });

            // Tampilkan / sembunyikan riwayat.
            const historyButton = document.getElementById('toggleHistory');
            const historyContent = document.getElementById('historyContent');
            const historyToggleText = document.getElementById('historyToggleText');
            const historyToggleIcon = document.getElementById('historyToggleIcon');

            historyButton?.addEventListener('click', function () {
                if (!historyContent) return;

                const willShow = historyContent.classList.contains('hidden');

                historyContent.classList.toggle('hidden', !willShow);
                historyButton.setAttribute('aria-expanded', String(willShow));

                if (historyToggleText) {
                    historyToggleText.textContent = willShow
                        ? 'Sembunyikan Riwayat'
                        : 'Lihat Riwayat Dokumen';
                }

                if (historyToggleIcon) {
                    historyToggleIcon.className = willShow
                        ? 'fa-solid fa-eye-slash'
                        : 'fa-solid fa-eye';
                }
            });
        });
    </script>

</body>
</html>
