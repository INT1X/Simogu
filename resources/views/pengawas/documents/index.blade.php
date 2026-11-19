
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Dokumen - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100">

<div class="min-h-screen">

    {{-- SIDEBAR --}}
    @include('components.pengawas-sidebar')

    {{-- AREA UTAMA --}}
    <div class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="sticky top-0 z-20 bg-white border-b border-slate-200">
            <div class="px-6 py-5">
                <div class="flex items-center justify-between gap-4">

                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">
                            Verifikasi dan Penilaian Dokumen
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Periksa dokumen guru, lihat nilai sebelumnya, dan perbarui penilaian.
                        </p>
                    </div>

                    <div class="relative">
                        <div
                            class="w-11 h-11 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center"
                            title="Dokumen menunggu verifikasi"
                        >
                            <i class="fa-solid fa-bell text-lg"></i>

                            @if(($pendingCount ?? 0) > 0)
                                <span class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1 rounded-full bg-red-500 text-white text-[11px] font-bold flex items-center justify-center">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-6">

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: @json(session('success')),
                            confirmButtonText: 'OK'
                        });
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: @json(session('error')),
                            confirmButtonText: 'OK'
                        });
                    });
                </script>
            @endif

            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">

                {{-- MENUNGGU --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                Menunggu Verifikasi
                            </p>

                            <p class="text-3xl font-bold text-amber-600 mt-1">
                                {{ $pendingCount ?? '—' }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                            <i class="fa-solid fa-clock text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- SUDAH DIVERIFIKASI --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                Sudah Diverifikasi
                            </p>

                            <p class="text-3xl font-bold text-emerald-600 mt-1">
                                {{ $verifiedCount ?? '—' }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i class="fa-solid fa-circle-check text-xl"></i>
                        </div>
                    </div>
                </div>

                {{-- SEKOLAH --}}
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500">
                                Sekolah Binaan
                            </p>

                            <p class="text-lg font-bold text-slate-800 mt-1">
                                {{ $supervisor->school->name ?? '-' }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                            <i class="fa-solid fa-school text-xl"></i>
                        </div>
                    </div>
                </div>

            </div>

            {{-- DAFTAR DOKUMEN --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- JUDUL DAN TOMBOL ARSIP --}}
                <div class="px-6 py-5 border-b border-slate-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                {{ ($isArchive ?? false) ? 'Arsip Dokumen Guru' : 'Daftar Dokumen Guru' }}
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                @if($isArchive ?? false)
                                    Dokumen dari periode sebelumnya, dokumen tanpa periode, dan dokumen yang ditolak.
                                @else
                                    Dokumen pada periode utama. Dokumen terverifikasi tetap dapat dibuka untuk melihat atau memperbarui nilai.
                                @endif
                            </p>

                            @if(!($isArchive ?? false) && !empty($currentPeriod))
                                <p class="text-sm text-blue-700 font-semibold mt-2">
                                    <i class="fa-solid fa-calendar-check mr-1"></i>
                                    Periode utama: {{ $currentPeriod->name }}
                                </p>
                            @endif
                        </div>

                        @if($isArchive ?? false)
                            <a
                                href="{{ route('pengawas.documents.index') }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition"
                            >
                                <i class="fa-solid fa-arrow-left"></i>
                                Daftar Utama
                            </a>
                        @else
                            <a
                                href="{{ route('pengawas.documents.index', ['arsip' => 1]) }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-sm font-semibold transition"
                            >
                                <i class="fa-solid fa-box-archive"></i>
                                Arsip Dokumen
                            </a>
                        @endif

                    </div>
                </div>

                {{-- FILTER PERIODE --}}
                <form
                    method="GET"
                    action="{{ route('pengawas.documents.index') }}"
                    class="p-6 bg-slate-50 border-b border-slate-200"
                >

                    @if($isArchive ?? false)
                        <input type="hidden" name="arsip" value="1">
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- TAHUN AJARAN --}}
                        <div>
                            <label
                                for="academic_year"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Tahun Ajaran
                            </label>

                            <select
                                id="academic_year"
                                name="academic_year"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Semua Tahun Ajaran</option>

                                @foreach(($periods ?? collect())->pluck('academic_year')->filter()->unique()->sortDesc() as $year)
                                    <option
                                        value="{{ $year }}"
                                        @selected((string) request('academic_year') === (string) $year)
                                    >
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- SEMESTER --}}
                        <div>
                            <label
                                for="semester"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Semester
                            </label>

                            <select
                                id="semester"
                                name="semester"
                                class="w-full rounded-xl border border-slate-300 bg-white px-3 py-3 text-sm focus:border-blue-500 focus:ring-blue-500"
                            >
                                <option value="">Semua Semester</option>

                                @foreach(($periods ?? collect())->pluck('semester')->filter()->unique()->sort() as $semesterOption)
                                    <option
                                        value="{{ $semesterOption }}"
                                        @selected((string) request('semester') === (string) $semesterOption)
                                    >
                                        {{ ucfirst($semesterOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TOMBOL FILTER --}}
                        <div class="flex items-end gap-2">
                            <button
                                type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition"
                            >
                                <i class="fa-solid fa-filter"></i>
                                Terapkan
                            </button>

                            <a
                                href="{{ route('pengawas.documents.index', ($isArchive ?? false) ? ['arsip' => 1] : []) }}"
                                class="inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 text-sm font-semibold transition"
                            >
                                Reset
                            </a>
                        </div>

                    </div>
                </form>

                {{-- ISI DAFTAR --}}
                @if($documents->count() > 0)

                    <div class="divide-y divide-slate-100">

                        @foreach($documents as $document)

                            @php
                                $isVerified = $document->status === 'verified';
                                $isRejected = $document->status === 'rejected';
                                $isPending = $document->status === 'pending';

                                $maxScore = (float) ($document->documentType->max_score ?? 0);

                                $latestVerification = $document->verifications
                                    ->sortByDesc(function ($verification) {
                                        return $verification->verified_at
                                            ?? $verification->created_at;
                                    })
                                    ->first();

                                $previousScore = $latestVerification?->score;
                            @endphp

                            <div class="p-6 hover:bg-slate-50 transition">

                                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

                                    {{-- INFORMASI DOKUMEN --}}
                                    <div class="flex items-start gap-4">

                                        <div class="w-14 h-14 shrink-0 rounded-xl
                                            {{ $isVerified
                                                ? 'bg-emerald-100 text-emerald-600'
                                                : ($isRejected
                                                    ? 'bg-red-100 text-red-600'
                                                    : 'bg-blue-100 text-blue-600') }}
                                            flex items-center justify-center"
                                        >
                                            <i class="fa-solid fa-file-lines text-2xl"></i>
                                        </div>

                                        <div class="min-w-0">

                                            <h3 class="font-bold text-slate-800 text-lg break-words">
                                                {{ $document->title }}
                                            </h3>

                                            <p class="text-sm text-slate-500 mt-1">
                                                <i class="fa-solid fa-user mr-1"></i>
                                                {{ $document->teacher->name ?? '-' }}
                                            </p>

                                            <p class="text-sm text-slate-500 mt-1">
                                                <i class="fa-solid fa-tag mr-1"></i>
                                                {{ $document->documentType->name ?? 'Tanpa jenis' }}
                                            </p>

                                            {{-- PERIODE DOKUMEN --}}
                                            @if($document->assessmentPeriod)
                                                <p class="text-sm text-indigo-700 mt-1">
                                                    <i class="fa-solid fa-calendar-days mr-1"></i>
                                                    Periode: {{ $document->assessmentPeriod->name }}
                                                </p>
                                            @else
                                                <p class="text-sm text-amber-700 mt-1">
                                                    <i class="fa-solid fa-calendar-xmark mr-1"></i>
                                                    Belum terhubung dengan periode penilaian
                                                </p>
                                            @endif

                                            {{-- NILAI MAKSIMAL --}}
                                            @if($document->documentType)
                                                <p class="text-sm text-blue-700 mt-1">
                                                    <i class="fa-solid fa-star mr-1"></i>
                                                    Nilai maksimal:
                                                    {{ number_format($maxScore, 2, ',', '.') }}
                                                </p>
                                            @endif

                                            {{-- NILAI VERIFIKASI --}}
                                            @if($isVerified && $previousScore !== null)
                                                <p class="text-sm text-emerald-700 font-semibold mt-1">
                                                    <i class="fa-solid fa-check-double mr-1"></i>
                                                    Nilai sebelumnya:
                                                    {{ number_format((float) $previousScore, 2, ',', '.') }}

                                                    @if($maxScore > 0)
                                                        / {{ number_format($maxScore, 2, ',', '.') }}
                                                    @endif
                                                </p>
                                            @endif

                                            {{-- ALASAN PENOLAKAN --}}
                                            @if($isRejected)
                                                <div class="mt-2 p-3 rounded-xl bg-red-50 border border-red-100">
                                                    <p class="text-xs font-semibold text-red-700">
                                                        <i class="fa-solid fa-circle-exclamation mr-1"></i>
                                                        Alasan penolakan
                                                    </p>

                                                    <p class="text-sm text-red-700 mt-1 whitespace-pre-line break-words">
                                                        {{ $latestVerification?->notes ?? $document->notes ?? 'Tidak ada catatan penolakan.' }}
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- NAMA FILE --}}
                                            @if($document->original_name)
                                                <p class="text-xs text-slate-400 mt-2 break-all">
                                                    <i class="fa-solid fa-paperclip mr-1"></i>
                                                    {{ $document->original_name }}
                                                </p>
                                            @endif

                                            {{-- TANGGAL UPLOAD --}}
                                            <p class="text-xs text-slate-400 mt-2">
                                                <i class="fa-regular fa-clock mr-1"></i>
                                                Diunggah:
                                                {{ $document->created_at?->format('d-m-Y H:i') ?? '-' }}
                                            </p>

                                        </div>
                                    </div>

                                    {{-- STATUS DAN AKSI --}}
                                    <div class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-center gap-3">

                                        {{-- STATUS --}}
                                        @if($isVerified)

                                            <span class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Sudah Diverifikasi
                                            </span>

                                        @elseif($isRejected)

                                            <span class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                <i class="fa-solid fa-circle-xmark"></i>
                                                Ditolak
                                            </span>

                                        @else

                                            <span class="inline-flex items-center justify-center gap-2 px-3 py-2 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                                <i class="fa-solid fa-clock"></i>
                                                Menunggu Verifikasi
                                            </span>

                                        @endif

                                        {{-- PERIKSA / PERBARUI NILAI --}}
                                        @if(!$isRejected)

                                            <a
                                                href="{{ route('pengawas.documents.show', $document) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl {{ $isVerified ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white text-sm font-semibold transition"
                                            >
                                                @if($isVerified)
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    Lihat / Perbarui Nilai
                                                @else
                                                    <i class="fa-solid fa-eye"></i>
                                                    Periksa & Beri Nilai
                                                @endif
                                            </a>

                                        @endif

                                        {{-- DOWNLOAD DOKUMEN --}}
                                        @if($document->file_path)
                                            <a
                                                href="{{ route('pengawas.documents.download', $document) }}"
                                                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-600 hover:bg-slate-700 text-white text-sm font-semibold transition"
                                            >
                                                <i class="fa-solid fa-download"></i>
                                                Unduh
                                            </a>
                                        @endif

                                        {{-- TOLAK HANYA DOKUMEN PENDING --}}
                                        @if($isPending)

                                            <form
                                                method="POST"
                                                action="{{ route('pengawas.documents.reject', $document) }}"
                                                class="reject-form"
                                            >
                                                @csrf
                                                @method('PUT')

                                                <input
                                                    type="hidden"
                                                    name="notes"
                                                    value=""
                                                >

                                                <button
                                                    type="submit"
                                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-700 transition"
                                                >
                                                    <i class="fa-solid fa-xmark"></i>
                                                    Tolak
                                                </button>
                                            </form>

                                        @endif

                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>

                    {{-- PAGINATION --}}
                    @if($documents->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200">
                            {{ $documents->links() }}
                        </div>
                    @endif

                @else

                    {{-- KOSONG --}}
                    <div class="px-6 py-16 text-center">

                        <div class="mx-auto w-20 h-20 rounded-2xl bg-slate-100 text-slate-500 flex items-center justify-center">
                            <i class="fa-solid {{ ($isArchive ?? false) ? 'fa-box-open' : 'fa-folder-open' }} text-3xl"></i>
                        </div>

                        <h3 class="mt-5 text-lg font-bold text-slate-800">
                            {{ ($isArchive ?? false) ? 'Arsip Dokumen Kosong' : 'Belum Ada Dokumen' }}
                        </h3>

                        <p class="text-sm text-slate-500 mt-2 max-w-lg mx-auto">
                            @if($isArchive ?? false)
                                Belum ada dokumen yang sesuai dengan periode atau filter arsip yang dipilih.
                            @else
                                Belum ada dokumen pada periode ini. Periksa filter tahun ajaran dan semester atau buka arsip dokumen.
                            @endif
                        </p>

                        @if(!($isArchive ?? false))
                            <a
                                href="{{ route('pengawas.documents.index', ['arsip' => 1]) }}"
                                class="inline-flex items-center gap-2 mt-5 px-4 py-2.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-sm font-semibold transition"
                            >
                                <i class="fa-solid fa-box-archive"></i>
                                Buka Arsip
                            </a>
                        @endif

                    </div>

                @endif

            </div>

        </main>
    </div>
</div>

{{-- SWEETALERT PENOLAKAN --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.reject-form').forEach(function (form) {

        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Tolak dokumen?',
                text: 'Dokumen akan ditandai sebagai ditolak dan tetap disimpan di arsip. File tidak dihapus.',
                icon: 'warning',
                input: 'textarea',
                inputLabel: 'Alasan Penolakan',
                inputPlaceholder: 'Tuliskan alasan penolakan...',
                inputAttributes: {
                    maxlength: 2000,
                    'aria-label': 'Alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Ya, tolak dokumen',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                reverseButtons: true,

                inputValidator: function (value) {
                    if (!value || !value.trim()) {
                        return 'Alasan penolakan wajib diisi.';
                    }

                    if (value.trim().length > 2000) {
                        return 'Alasan maksimal 2000 karakter.';
                    }
                }
            }).then(function (result) {

                if (!result.isConfirmed) {
                    return;
                }

                const notesInput = form.querySelector('input[name="notes"]');

                if (!notesInput) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Kolom alasan penolakan tidak ditemukan.'
                    });

                    return;
                }

                notesInput.value = result.value.trim();

                const button = form.querySelector('button');

                if (button) {
                    button.disabled = true;
                    button.innerHTML =
                        '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
                }

                Swal.fire({
                    title: 'Memproses penolakan...',
                    text: 'Dokumen sedang diperbarui. Mohon tunggu.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: function () {
                        Swal.showLoading();
                    }
                });

                form.submit();
            });
        });

    });

});
</script>

</body>
</html>
