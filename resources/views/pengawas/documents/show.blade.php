
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periksa Dokumen - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100">

@php
    /*
    |--------------------------------------------------------------------------
    | Status dokumen
    |--------------------------------------------------------------------------
    */
    $documentStatus = $document->status;

    $isVerified = $documentStatus === 'verified';
    $isRejected = $documentStatus === 'rejected';
    $isPending = $documentStatus === 'pending';

    /*
    |--------------------------------------------------------------------------
    | Ambil verifikasi terbaru
    |--------------------------------------------------------------------------
    | Diselaraskan dengan controller:
    | latest('verified_at')->latest('id')
    */
    $latestVerification = $document->verifications
        ->sortByDesc(function ($verification) {
            return [
                $verification->verified_at
                    ? \Carbon\Carbon::parse($verification->verified_at)->timestamp
                    : 0,
                $verification->id ?? 0,
            ];
        })
        ->first();

    /*
    |--------------------------------------------------------------------------
    | Nilai maksimal dan nilai sebelumnya
    |--------------------------------------------------------------------------
    */
    $maxScore = $document->documentType
        ? (float) $document->documentType->max_score
        : 0;

    $previousScore = $latestVerification?->score;

    /*
    |--------------------------------------------------------------------------
    | Status verifikasi terakhir
    |--------------------------------------------------------------------------
    */
    $latestVerificationStatus = $latestVerification?->status;

    $latestVerificationStatusLabel = match ($latestVerificationStatus) {
        'verified' => 'Diterima',
        'rejected' => 'Ditolak',
        default => $latestVerificationStatus
            ? ucfirst($latestVerificationStatus)
            : 'Belum diverifikasi',
    };

    $latestVerificationDate = $latestVerification?->verified_at
        ?? $latestVerification?->created_at;
@endphp

<div class="min-h-screen">

    @include('components.pengawas-sidebar')

    <div class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="sticky top-0 z-20 bg-white border-b border-slate-200">
            <div class="px-6 py-5 flex items-center gap-4">

                <a href="{{ route('pengawas.documents.index', $isRejected ? ['arsip' => 1] : []) }}"
                    class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center hover:bg-blue-50 hover:text-blue-600"
                    aria-label="Kembali ke daftar dokumen">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Periksa Dokumen
                    </h1>

                    <p class="text-sm text-slate-500 mt-1">
                        Periksa dokumen, lihat nilai sebelumnya, dan perbarui verifikasi.
                    </p>
                </div>

            </div>
        </header>

        <main class="p-4 md:p-6">

            {{-- NOTIFIKASI --}}
            @if(session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700">
                    <i class="fa-solid fa-circle-check mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    <i class="fa-solid fa-circle-exclamation mr-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                    <p class="font-semibold mb-1">
                        Periksa kembali data berikut:
                    </p>

                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- STATUS DOKUMEN --}}
            @if($isRejected)
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-xmark text-xl mt-0.5"></i>

                        <div>
                            <p class="font-bold">Dokumen Ditolak</p>
                            <p class="text-sm mt-1">
                                Dokumen ini sudah ditolak. File dan data dokumen tetap tersimpan
                                dan dapat diakses melalui arsip. Formulir penilaian tidak tersedia
                                untuk dokumen yang telah ditolak.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($isVerified)
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-xl mt-0.5"></i>

                        <div>
                            <p class="font-bold">Dokumen Sudah Diterima</p>
                            <p class="text-sm mt-1">
                                Anda dapat memperbarui nilai dan catatan verifikasi.
                                Perubahan akan disimpan melalui proses verifikasi.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($isPending)
                <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-4 text-amber-800">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-clock text-xl mt-0.5"></i>

                        <div>
                            <p class="font-bold">Menunggu Verifikasi</p>
                            <p class="text-sm mt-1">
                                Periksa dokumen terlebih dahulu sebelum memberikan nilai
                                atau melakukan penolakan.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- INFORMASI DOKUMEN --}}
                <div class="xl:col-span-1">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-5 border-b border-slate-200">
                            <h2 class="font-bold text-lg text-slate-800">
                                Informasi Dokumen
                            </h2>
                        </div>

                        <div class="p-6 space-y-5">

                            {{-- GURU --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Guru
                                </p>

                                <p class="mt-1 font-semibold text-slate-800">
                                    {{ $document->teacher->name ?? '-' }}
                                </p>
                            </div>

                            {{-- JUDUL --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Judul Dokumen
                                </p>

                                <p class="mt-1 font-semibold text-slate-800 break-words">
                                    {{ $document->title ?? '-' }}
                                </p>
                            </div>

                            {{-- JENIS DOKUMEN --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Jenis Dokumen
                                </p>

                                <p class="mt-1 text-slate-700">
                                    {{ $document->documentType->name ?? '-' }}
                                </p>
                            </div>

                            {{-- PERIODE PENILAIAN --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Periode Penilaian
                                </p>

                                <p class="mt-1 font-semibold text-slate-800">
                                    {{ $document->assessmentPeriod?->name
                                        ?? 'Belum terhubung dengan periode penilaian' }}
                                </p>

                                @if($document->assessmentPeriod)
                                    <p class="mt-1 text-xs text-slate-500">
                                        Tahun ajaran:
                                        {{ $document->assessmentPeriod->academic_year ?? '-' }}
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Semester:
                                        {{ ucfirst($document->assessmentPeriod->semester ?? '-') }}
                                    </p>
                                @endif
                            </div>

                            {{-- NILAI MAKSIMAL --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Nilai Maksimal
                                </p>

                                <p class="mt-1 text-xl font-bold text-blue-700">
                                    {{ $document->documentType
                                        ? number_format($maxScore, 2, ',', '.')
                                        : '-' }}
                                </p>
                            </div>

                            {{-- FILE --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Nama File
                                </p>

                                <p class="mt-1 text-sm text-slate-700 break-all">
                                    {{ $document->original_name ?? '-' }}
                                </p>
                            </div>

                            {{-- TANGGAL UNGGAH --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Tanggal Unggah
                                </p>

                                <p class="mt-1 text-sm text-slate-700">
                                    {{ $document->created_at
                                        ? $document->created_at->format('d-m-Y H:i')
                                        : '-' }}
                                </p>
                            </div>

                            {{-- STATUS DOKUMEN --}}
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Status Dokumen
                                </p>

                                <div class="mt-2">
                                    @if($isVerified)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                            <i class="fa-solid fa-circle-check"></i>
                                            Sudah Diterima
                                        </span>
                                    @elseif($isRejected)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Ditolak
                                        </span>
                                    @elseif($isPending)
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                            <i class="fa-solid fa-clock"></i>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                            {{ ucfirst($documentStatus ?? 'Tidak diketahui') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- VERIFIKASI TERBARU --}}
                            @if($latestVerification)
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">

                                    <h3 class="font-semibold text-slate-800 mb-4">
                                        Verifikasi Terbaru
                                    </h3>

                                    <p class="text-sm text-slate-500">
                                        Status verifikasi
                                    </p>

                                    <p class="font-semibold text-slate-800 mb-3">
                                        {{ $latestVerificationStatusLabel }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        Nilai terakhir
                                    </p>

                                    <p class="text-2xl font-bold text-blue-700 mb-3">
                                        {{ $previousScore !== null
                                            ? number_format((float) $previousScore, 2, ',', '.')
                                            : 'Belum ada nilai' }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        Catatan verifikasi
                                    </p>

                                    <p class="text-sm text-slate-700 whitespace-pre-line break-words">
                                        {{ $latestVerification->notes ?: '-' }}
                                    </p>

                                    @if($latestVerificationDate)
                                        <p class="text-xs text-slate-400 mt-3">
                                            Terakhir diperiksa:
                                            {{ \Carbon\Carbon::parse($latestVerificationDate)->format('d-m-Y H:i') }}
                                        </p>
                                    @endif

                                </div>
                            @else
                                <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                    <h3 class="font-semibold text-slate-800">
                                        Riwayat Verifikasi
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        Belum ada catatan verifikasi untuk dokumen ini.
                                    </p>
                                </div>
                            @endif

                        </div>
                    </div>

                    {{-- FORM PENILAIAN --}}
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mt-6">

                        <h2 class="font-bold text-lg text-slate-800">
                            @if($isVerified)
                                Perbarui Verifikasi
                            @elseif($isPending)
                                Keputusan Dokumen
                            @elseif($isRejected)
                                Informasi Penolakan
                            @else
                                Verifikasi Dokumen
                            @endif
                        </h2>

                        <p class="text-sm text-slate-500 mt-1 mb-5">
                            @if($isVerified)
                                Perbarui nilai dan catatan jika hasil pemeriksaan berubah.
                            @elseif($isPending)
                                Masukkan nilai sesuai batas maksimal jenis dokumen,
                                atau tolak dokumen dengan alasan yang jelas.
                            @elseif($isRejected)
                                Dokumen yang telah ditolak tidak dapat dinilai kembali melalui halaman ini.
                            @else
                                Status dokumen tidak mendukung proses verifikasi.
                            @endif
                        </p>

                        @if(in_array($documentStatus, ['pending', 'verified'], true)
                            && $document->documentType)

                            {{-- FORM VERIFIKASI --}}
                            <form
                                id="verifyForm"
                                method="POST"
                                action="{{ route('pengawas.documents.verify', $document) }}"
                                class="space-y-4 mb-4"
                            >
                                @csrf
                                @method('PUT')

                                <div>
                                    <label for="score" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Nilai Dokumen
                                    </label>

                                    <input
                                        type="number"
                                        id="score"
                                        name="score"
                                        value="{{ old('score', $previousScore) }}"
                                        min="0"
                                        max="{{ $maxScore }}"
                                        step="0.01"
                                        required
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                        placeholder="Masukkan nilai"
                                    >

                                    <p class="text-xs text-slate-500 mt-2">
                                        Nilai minimum 0 dan maksimum
                                        {{ number_format($maxScore, 2, ',', '.') }}.
                                    </p>
                                </div>

                                <div>
                                    <label for="verification_notes" class="block text-sm font-semibold text-slate-700 mb-2">
                                        Catatan Verifikasi (Opsional)
                                    </label>

                                    <textarea
                                        id="verification_notes"
                                        name="notes"
                                        rows="4"
                                        maxlength="2000"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200"
                                        placeholder="Tambahkan catatan pemeriksaan"
                                    >{{ old('notes', $latestVerification?->notes ?? '') }}</textarea>
                                </div>

                                <button
                                    type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition"
                                >
                                    <i class="fa-solid fa-check"></i>

                                    {{ $isVerified
                                        ? 'Simpan Perubahan Verifikasi'
                                        : 'Terima Dokumen' }}
                                </button>
                            </form>

                            {{-- FORM PENOLAKAN HANYA UNTUK PENDING --}}
                            @if($isPending)
                                <form
                                    id="rejectForm"
                                    method="POST"
                                    action="{{ route('pengawas.documents.reject', $document) }}"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input
                                        type="hidden"
                                        id="rejection_notes"
                                        name="notes"
                                        value="{{ old('notes') }}"
                                    >

                                    <button
                                        type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition"
                                    >
                                        <i class="fa-solid fa-xmark"></i>
                                        Tolak Dokumen
                                    </button>
                                </form>
                            @endif

                        @elseif($isRejected)
                            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                                <p class="font-semibold">
                                    Dokumen sudah ditolak.
                                </p>

                                <p class="mt-1">
                                    Alasan penolakan dapat dilihat pada bagian
                                    verifikasi terbaru. Dokumen dan file tetap tersimpan.
                                </p>

                                <a
                                    href="{{ route('pengawas.documents.index', ['arsip' => 1]) }}"
                                    class="inline-flex items-center gap-2 mt-4 font-semibold text-red-700 hover:text-red-900"
                                >
                                    <i class="fa-solid fa-box-archive"></i>
                                    Kembali ke Arsip
                                </a>
                            </div>
                        @else
                            <div class="rounded-xl bg-slate-100 p-4 text-sm text-slate-600">
                                Jenis dokumen tidak tersedia atau status dokumen tidak mendukung verifikasi.
                            </div>
                        @endif

                    </div>
                </div>

                {{-- PREVIEW DOKUMEN --}}
                <div class="xl:col-span-2">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                        <div class="px-6 py-5 border-b border-slate-200">
                            <h2 class="font-bold text-lg text-slate-800">
                                Preview Dokumen
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Silakan periksa isi dokumen sebelum memberikan keputusan.
                            </p>
                        </div>

                        <div class="p-4 md:p-6">

                            @if($document->file_path
                                && \Illuminate\Support\Facades\Storage::disk('public')->exists($document->file_path))

                                <div
                                    class="w-full rounded-xl overflow-hidden border border-slate-200 bg-slate-50"
                                    style="height: 700px;"
                                >
                                    <iframe
                                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($document->file_path) }}"
                                        class="w-full h-full border-0"
                                        title="Preview dokumen"
                                    ></iframe>
                                </div>

                                <div class="mt-4 flex flex-wrap items-center gap-4">

                                    <a
                                        href="{{ route('pengawas.documents.download', $document) }}"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-800"
                                    >
                                        <i class="fa-solid fa-download"></i>
                                        Unduh Dokumen
                                    </a>

                                    @if($isRejected)
                                        <span class="inline-flex items-center gap-2 text-sm text-red-600">
                                            <i class="fa-solid fa-box-archive"></i>
                                            Tersimpan di arsip
                                        </span>
                                    @endif

                                </div>

                            @else
                                <div class="py-20 text-center">

                                    <div class="mx-auto w-20 h-20 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center">
                                        <i class="fa-solid fa-file-circle-xmark text-3xl"></i>
                                    </div>

                                    <h3 class="mt-5 font-bold text-slate-800">
                                        File Tidak Ditemukan
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-2">
                                        File dokumen tidak tersedia pada penyimpanan.
                                    </p>

                                    <p class="text-xs text-slate-400 mt-1">
                                        Data dokumen tetap tersimpan meskipun file fisik tidak ditemukan.
                                    </p>

                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const verifyForm = document.getElementById('verifyForm');
    const rejectForm = document.getElementById('rejectForm');
    const rejectionNotes = document.getElementById('rejection_notes');

    // Konfirmasi penyimpanan nilai dan verifikasi.
    if (verifyForm) {
        verifyForm.addEventListener('submit', function (event) {
            event.preventDefault();

            if (!verifyForm.reportValidity()) {
                return;
            }

            const scoreInput = document.getElementById('score');
            const score = Number(scoreInput.value);
            const minScore = Number(scoreInput.min);
            const maxScore = Number(scoreInput.max);

            if (
                !Number.isFinite(score) ||
                score < minScore ||
                score > maxScore
            ) {
                Swal.fire({
                    title: 'Nilai tidak valid',
                    text: 'Pastikan nilai berada dalam rentang yang diperbolehkan.',
                    icon: 'error',
                    confirmButtonText: 'Mengerti'
                });

                return;
            }

            Swal.fire({
                title: 'Simpan verifikasi?',
                text: 'Nilai dan catatan akan disimpan sesuai proses verifikasi.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, simpan',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#059669',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    verifyForm.submit();
                }
            });
        });
    }

    // Konfirmasi penolakan tanpa menghapus dokumen atau file.
    if (rejectForm && rejectionNotes) {
        rejectForm.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Tolak dokumen?',
                text: 'Dokumen akan ditandai ditolak. Data, file fisik, dan catatan verifikasi tetap tersimpan di arsip.',
                input: 'textarea',
                inputPlaceholder: 'Tuliskan alasan penolakan...',
                inputAttributes: {
                    maxlength: 2000,
                    'aria-label': 'Alasan penolakan'
                },
                inputValue: rejectionNotes.value,
                inputValidator: function (value) {
                    if (!value || !value.trim()) {
                        return 'Alasan penolakan wajib diisi.';
                    }

                    if (value.trim().length > 2000) {
                        return 'Alasan maksimal 2000 karakter.';
                    }

                    return undefined;
                },
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, tolak dokumen',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    rejectionNotes.value = result.value.trim();
                    rejectForm.submit();
                }
            });
        });
    }
});
</script>

</body>
</html>
