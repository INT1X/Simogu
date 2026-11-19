
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periode Penilaian Semester - SIMOGU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen w-auto">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-start gap-3">
                        <div class="w-10 shrink-0 lg:hidden"></div>

                        <div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-8 bg-amber-500 rounded-full"></div>
                                <h1 class="text-2xl font-bold text-slate-800">
                                    Periode Penilaian Semester
                                </h1>
                            </div>

                            <p class="text-slate-500 mt-1">
                                Kelola tahun ajaran dan periode penilaian guru.
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('admin.assessment-periods.create') }}"
                       class="inline-flex items-center justify-center gap-2 px-5 py-3
                              rounded-xl bg-amber-500 text-white font-semibold
                              hover:bg-amber-600 transition shadow-sm">
                        <span class="text-xl leading-none">+</span>
                        Tambah Periode
                    </a>

                </div>
            </div>
        </header>

        {{-- KONTEN --}}
        <section class="w-full p-4 sm:p-6 lg:p-8">

            {{-- NOTIFIKASI --}}
            @if (session('success'))
                <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50
                            px-5 py-4 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50
                            px-5 py-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- RINGKASAN --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <p class="text-sm font-medium text-slate-500">Total Periode</p>
                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $assessmentPeriods->total() }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">Semua periode terdaftar</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <p class="text-sm font-medium text-slate-500">Periode Aktif</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ \App\Models\AssessmentPeriod::where('status', 'active')->count() }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">Periode yang sedang aktif</p>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                    <p class="text-sm font-medium text-slate-500">Periode Draft</p>
                    <p class="text-3xl font-bold text-amber-500 mt-2">
                        {{ \App\Models\AssessmentPeriod::where('status', 'draft')->count() }}
                    </p>
                    <p class="text-xs text-slate-500 mt-2">Periode yang belum diaktifkan</p>
                </div>

            </div>

            {{-- TABEL PERIODE --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 sm:px-6 py-5 border-b border-slate-200">
                    <h2 class="text-lg font-bold text-slate-800">
                        Daftar Periode
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Daftar tahun ajaran dan semester yang tersedia dalam sistem.
                    </p>
                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">

                        <thead class="bg-slate-50 text-slate-600">
                            <tr>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">No.</th>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">Tahun Ajaran</th>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">Semester</th>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">Tanggal Mulai</th>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">Tanggal Selesai</th>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">Status</th>
                                <th class="px-5 py-4 font-semibold whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($assessmentPeriods as $period)
                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-5 py-4 text-slate-500">
                                        {{ $assessmentPeriods->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-5 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                        {{ $period->academic_year }}
                                    </td>

                                    <td class="px-5 py-4 text-slate-700">
                                        {{ ucfirst($period->semester) }}
                                    </td>

                                    <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                        {{ $period->start_date?->format('d-m-Y') ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-slate-600 whitespace-nowrap">
                                        {{ $period->end_date?->format('d-m-Y') ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @if ($period->status === 'active')
                                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full
                                                         text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @elseif ($period->status === 'closed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full
                                                         text-xs font-semibold bg-slate-100 text-slate-600">
                                                Ditutup
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full
                                                         text-xs font-semibold bg-amber-100 text-amber-700">
                                                Draft
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">

                                            <a href="{{ route('admin.assessment-periods.edit', $period) }}"
                                               class="inline-flex items-center px-3 py-2 rounded-lg
                                                      bg-blue-50 text-blue-700 font-medium
                                                      hover:bg-blue-100 transition">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.assessment-periods.destroy', $period) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus periode ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center px-3 py-2 rounded-lg
                                                               bg-red-50 text-red-700 font-medium
                                                               hover:bg-red-100 transition">
                                                    Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-14 text-center">
                                        <div class="mx-auto max-w-md">
                                            <div class="mx-auto w-14 h-14 rounded-2xl bg-amber-50
                                                        flex items-center justify-center text-amber-500 text-2xl">
                                                &#128197;
                                            </div>

                                            <h3 class="mt-4 font-bold text-slate-800">
                                                Belum Ada Periode Penilaian
                                            </h3>

                                            <p class="mt-2 text-sm text-slate-500">
                                                Tambahkan tahun ajaran dan semester untuk mulai mengelola periode penilaian.
                                            </p>

                                            <a href="{{ route('admin.assessment-periods.create') }}"
                                               class="inline-flex mt-5 px-5 py-3 rounded-xl
                                                      bg-amber-500 text-white font-semibold
                                                      hover:bg-amber-600 transition">
                                                Tambah Periode Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                @if ($assessmentPeriods->hasPages())
                    <div class="px-5 sm:px-6 py-4 border-t border-slate-200">
                        {{ $assessmentPeriods->links() }}
                    </div>
                @endif

            </div>

            <p class="mt-4 text-xs text-slate-500">
                Catatan: periode aktif digunakan sebagai acuan untuk penilaian semester setelah
                proses penilaian pengawas dihubungkan ke periode semester.
            </p>

        </section>

    </main>

</body>
</html>
