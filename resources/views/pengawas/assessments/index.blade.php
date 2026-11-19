
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.pengawas-sidebar')

    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Penilaian Guru
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Kelola penilaian kinerja guru binaan Anda.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-3">

                        <a href="{{ route('pengawas.reports.index') }}"
                           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold shadow-sm hover:shadow-md transition">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 17v-2m3 2v-4m3 4v-6m2 9H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v10a2 2 0 01-2 2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14 3v5h5" />
                            </svg>

                            Laporan
                        </a>

                        <div class="text-left sm:text-right">
                            <p class="font-semibold text-slate-800">
                                {{ auth()->user()?->name ?? 'Pengawas' }}
                            </p>

                            <p class="text-sm text-blue-600">
                                Pengawas
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </header>

        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">

            {{-- NOTIFIKASI SUKSES --}}
            @if(session('success'))
                <div role="status"
                     class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- NOTIFIKASI ERROR --}}
            @if(session('error'))
                <div role="alert"
                     class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION ERROR --}}
            @if($errors->any())
                <div role="alert"
                     class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4">

                    <p class="font-bold text-red-700 mb-2">
                        Terjadi kesalahan:
                    </p>

                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- INFORMASI --}}
            <div class="mb-6 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-white shadow-lg">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <p class="text-blue-100 text-sm">
                            Modul Penilaian
                        </p>

                        <h2 class="text-2xl font-bold mt-1">
                            Penilaian Kinerja Guru
                        </h2>

                        <p class="text-sm text-blue-100 mt-2">
                            Pilih guru binaan untuk melihat atau memperbarui penilaian.
                        </p>
                    </div>

                    <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-.664-.054-1.316-.156-1.956z" />
                        </svg>
                    </div>

                </div>
            </div>

            {{-- DATA UNTUK RINGKASAN --}}
            @php
                /*
                 * Mendukung Collection dan Paginator.
                 * Jika menggunakan pagination, ringkasan di bawah
                 * dihitung dari guru pada halaman yang sedang dibuka.
                 */
                $teacherRows = $teachers instanceof \Illuminate\Pagination\AbstractPaginator
                    ? $teachers->getCollection()
                    : collect($teachers ?? []);

                $totalGuru = $teachers instanceof \Illuminate\Pagination\AbstractPaginator
                    ? $teachers->total()
                    : $teacherRows->count();

                $totalCompleted = $teacherRows
                    ->filter(fn ($teacher) => ($teacher->assessment_status ?? 'not_started') === 'completed')
                    ->count();

                $totalDraft = $teacherRows
                    ->filter(fn ($teacher) => ($teacher->assessment_status ?? 'not_started') === 'draft')
                    ->count();

                $totalNotStarted = $teacherRows
                    ->filter(fn ($teacher) => ($teacher->assessment_status ?? 'not_started') === 'not_started')
                    ->count();
            @endphp

            {{-- RINGKASAN STATUS --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Belum Dinilai</p>

                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $totalNotStarted }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Belum memiliki catatan penilaian
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-amber-200 p-5 shadow-sm">
                    <p class="text-sm text-amber-700">Draft</p>

                    <p class="text-2xl font-bold text-amber-700 mt-1">
                        {{ $totalDraft }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Penilaian belum selesai
                    </p>
                </div>

                <div class="bg-white rounded-xl border border-emerald-200 p-5 shadow-sm">
                    <p class="text-sm text-emerald-700">Sudah Dinilai</p>

                    <p class="text-2xl font-bold text-emerald-700 mt-1">
                        {{ $totalCompleted }}
                    </p>

                    <p class="text-xs text-slate-400 mt-1">
                        Penilaian berstatus completed
                    </p>
                </div>

            </div>

            {{-- DAFTAR GURU --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 sm:px-6 py-5 border-b border-slate-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                Daftar Guru Binaan
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Status berdasarkan catatan penilaian terbaru dari pengawas.
                            </p>
                        </div>

                        <div class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold">
                            {{ $totalGuru }} Guru
                        </div>

                    </div>
                </div>

                {{-- TABEL --}}
                <div class="overflow-x-auto">
                    <table class="w-full">

                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Guru
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Sekolah
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Nilai Akhir
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($teachers as $teacher)

                                @php
                                    $status = $teacher->assessment_status ?? 'not_started';
                                    $assessment = $teacher->assessment ?? null;
                                    $finalScore = $assessment?->final_score;
                                @endphp

                                <tr class="hover:bg-slate-50 transition">

                                    {{-- GURU --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold flex-shrink-0">
                                                {{ strtoupper(substr($teacher->name ?? '?', 0, 1)) }}
                                            </div>

                                            <div>
                                                <p class="font-semibold text-slate-800">
                                                    {{ $teacher->name ?? 'Nama tidak tersedia' }}
                                                </p>

                                                @if($teacher->nip)
                                                    <p class="text-xs text-slate-400 mt-1">
                                                        NIP: {{ $teacher->nip }}
                                                    </p>
                                                @endif
                                            </div>

                                        </div>
                                    </td>

                                    {{-- SEKOLAH --}}
                                    <td class="px-5 py-4">
                                        @if($teacher->school)
                                            <p class="text-sm font-medium text-slate-700">
                                                {{ $teacher->school->name }}
                                            </p>
                                        @else
                                            <span class="text-sm text-slate-400">-</span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-5 py-4 text-center">

                                        @if($status === 'completed')

                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Sudah Dinilai
                                            </span>

                                        @elseif($status === 'draft')

                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Draft — Belum Selesai
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                                Belum Dinilai
                                            </span>

                                        @endif

                                    </td>

                                    {{-- NILAI AKHIR --}}
                                    <td class="px-5 py-4 text-center">

                                        @if($finalScore !== null && $finalScore !== '')
                                            <span class="text-sm font-bold text-slate-800">
                                                {{ number_format((float) $finalScore, 2, ',', '.') }}
                                            </span>

                                            @if($status === 'draft')
                                                <p class="text-xs text-amber-600 mt-1">
                                                    Nilai sementara
                                                </p>
                                            @endif
                                        @else
                                            <span class="text-sm text-slate-400">-</span>
                                        @endif

                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center gap-2 flex-wrap">

                                            {{-- LIHAT GURU --}}
                                            <a href="{{ route('pengawas.teachers.show', $teacher) }}"
                                               class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-semibold transition">

                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>

                                                Lihat
                                            </a>

                                            {{-- EDIT PENILAIAN SELESAI --}}
                                            @if($assessment && $status === 'completed')

                                                <a href="{{ route('pengawas.assessments.create', ['teacher_id' => $teacher->id]) }}"
                                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold transition">

                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1-1 1 1-4 9.5-9.5z" />
                                                    </svg>

                                                    Edit Nilai
                                                </a>

                                            {{-- LANJUTKAN DRAFT --}}
                                            @elseif($assessment && $status === 'draft')

                                                <a href="{{ route('pengawas.assessments.create', ['teacher_id' => $teacher->id]) }}"
                                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold transition">

                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>

                                                    Lanjutkan Draft
                                                </a>

                                            {{-- MULAI PENILAIAN --}}
                                            @else

                                                <a href="{{ route('pengawas.assessments.create', ['teacher_id' => $teacher->id]) }}"
                                                   class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold transition">

                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 4v16m8-8H4" />
                                                    </svg>

                                                    Mulai Nilai
                                                </a>

                                            @endif

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center">

                                        <div class="flex flex-col items-center justify-center">

                                            <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                                                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0zm5 0a3 3 0 01-6 0" />
                                                </svg>
                                            </div>

                                            <p class="font-semibold text-slate-700">
                                                Belum Ada Guru Binaan
                                            </p>

                                            <p class="text-sm text-slate-400 mt-1 max-w-md">
                                                Guru dari sekolah yang Anda awasi akan muncul di sini.
                                            </p>

                                        </div>

                                    </td>
                                </tr>

                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($teachers instanceof \Illuminate\Pagination\AbstractPaginator)
                    <div class="px-5 py-4 border-t border-slate-200">
                        {{ $teachers->links() }}
                    </div>
                @endif

            </div>

        </section>
    </main>

</body>
</html>
