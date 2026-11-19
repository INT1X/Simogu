
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penilaian Guru | SIMOGU</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8fafc;
        }

        .panel {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            overflow: hidden;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 10px;
            color: #cbd5e1;
            font-size: 14px;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: #2563eb;
            color: white;
        }

        @media (max-width: 767px) {
            .sidebar {
                position: relative !important;
                width: 100% !important;
                height: auto !important;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="min-h-screen text-slate-800">

@php
    $teacher = $assessment->teacher;
    $teacherName = $teacher->user->name
        ?? $teacher->nama
        ?? $teacher->name
        ?? 'Guru';

    $competencies = [
        'pedagogik' => [
            'label' => 'Kompetensi Pedagogik',
            'icon' => 'fa-book-open',
        ],
        'kepribadian' => [
            'label' => 'Kompetensi Kepribadian',
            'icon' => 'fa-user-shield',
        ],
        'sosial' => [
            'label' => 'Kompetensi Sosial',
            'icon' => 'fa-people-group',
        ],
        'profesional' => [
            'label' => 'Kompetensi Profesional',
            'icon' => 'fa-graduation-cap',
        ],
    ];

    $details = $assessment->details->loadMissing('indicator');

    $groupedDetails = $details->groupBy(function ($detail) {
        return $detail->indicator->competency ?? 'lainnya';
    });
@endphp

<div class="sidebar bg-slate-900 text-white md:fixed md:inset-y-0 md:left-0 md:w-64 md:h-screen flex flex-col">
    <div class="p-6 border-b border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center">
                <i class="fa-solid fa-graduation-cap text-xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold">SIMOGU</h1>
                <p class="text-xs text-slate-400 mt-1">Sistem Informasi Guru</p>
            </div>
        </div>
    </div>

    <nav class="p-5 space-y-2">
        <p class="text-xs text-slate-500 uppercase tracking-wider mb-3">
            Menu Pengawas
        </p>

        <a href="{{ route('pengawas.assessments.index') }}"
           class="sidebar-link active">
            <i class="fa-solid fa-clipboard-check w-5"></i>
            Penilaian Guru
        </a>

        <a href="{{ route('pengawas.assessments.index') }}"
           class="sidebar-link">
            <i class="fa-solid fa-list-check w-5"></i>
            Daftar Penilaian
        </a>
    </nav>

    <div class="mt-auto p-5 border-t border-slate-700">
        <p class="text-sm font-semibold">
            {{ $supervisor->user->name ?? 'Pengawas' }}
        </p>
        <p class="text-xs text-slate-400 mt-1">Pengawas Sekolah</p>
    </div>
</div>

<main class="main-content md:ml-64 min-h-screen">
    <header class="bg-white border-b border-slate-200 px-5 md:px-8 py-5">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div>
                <p class="text-xs text-slate-500 mb-1">
                    SIMOGU / Penilaian Guru / Detail
                </p>
                <h2 class="text-xl font-bold">Detail Penilaian Guru</h2>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('pengawas.assessments.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 text-sm font-semibold hover:bg-slate-50">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

                <a href="{{ route('pengawas.assessments.edit', $assessment) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit
                </a>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto p-5 md:p-8">

        @if (session('success'))
            <div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200 text-green-800">
                <i class="fa-solid fa-circle-check mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Banner detail --}}
        <section class="rounded-2xl bg-gradient-to-r from-blue-700 to-indigo-700 text-white p-6 md:p-8 mb-6">
            <p class="text-sm text-blue-100 mb-2">Detail hasil penilaian</p>
            <h1 class="text-2xl md:text-3xl font-bold mb-3">
                {{ $teacherName }}
            </h1>
            <p class="text-sm text-blue-100">
                Tanggal penilaian:
                {{ \Illuminate\Support\Carbon::parse($assessment->assessment_date)->format('d F Y') }}
            </p>

            <div class="mt-5">
                @if ($assessment->status === 'completed')
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-green-100 text-green-800 text-xs font-bold">
                        <i class="fa-solid fa-circle-check"></i>
                        Penilaian Selesai
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">
                        <i class="fa-solid fa-clock"></i>
                        Draft Penilaian
                    </span>
                @endif
            </div>
        </section>

        {{-- Ringkasan nilai --}}
        <section class="mb-6">
            <h3 class="font-bold text-lg mb-4">Ringkasan Nilai</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                @foreach ($competencies as $key => $competency)
                    <div class="panel p-5">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid {{ $competency['icon'] }}"></i>
                            </div>
                            <p class="text-sm font-semibold text-slate-600">
                                {{ $competency['label'] }}
                            </p>
                        </div>

                        <p class="text-3xl font-bold text-slate-800">
                            {{ number_format((float) ($assessment->{$key . '_score'} ?? 0), 2, ',', '.') }}
                        </p>

                        <div class="h-2 bg-slate-100 rounded-full mt-4 overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full"
                                 style="width: {{ max(0, min(100, (float) ($assessment->{$key . '_score'} ?? 0))) }}%">
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="panel p-5">
                    <p class="text-sm text-slate-500 mb-3">Nilai Dokumen</p>
                    <p class="text-3xl font-bold text-slate-800">
                        {{ number_format((float) ($assessment->document_score ?? 0), 2, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-3">
                        Nilai dokumen yang tersimpan
                    </p>
                </div>

                <div class="panel p-5 border-blue-200">
                    <p class="text-sm text-slate-500 mb-3">Nilai Akhir</p>
                    <p class="text-3xl font-bold text-blue-700">
                        {{ number_format((float) ($assessment->final_score ?? 0), 2, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-3">
                        Nilai akhir yang tersimpan
                    </p>
                </div>

                <div class="panel p-5">
                    <p class="text-sm text-slate-500 mb-3">Klasifikasi</p>
                    <p class="text-xl font-bold text-slate-800">
                        {{ $assessment->classification ?: 'Belum ditentukan' }}
                    </p>
                    <p class="text-xs text-slate-400 mt-3">
                        Berdasarkan hasil klasifikasi tersimpan
                    </p>
                </div>
            </div>
        </section>

        {{-- Rincian indikator --}}
        <section class="panel mb-6">
            <div class="px-5 md:px-6 py-5 border-b border-slate-200">
                <h3 class="text-lg font-bold">Rincian Indikator Penilaian</h3>
                <p class="text-sm text-slate-500 mt-1">
                    Nilai dan catatan dari setiap indikator yang telah disimpan.
                </p>
            </div>

            @forelse ($groupedDetails as $competencyKey => $items)
                <div class="border-b border-slate-200 last:border-b-0">
                    <div class="px-5 md:px-6 py-4 bg-slate-50">
                        <h4 class="font-bold text-slate-800">
                            {{ $competencies[$competencyKey]['label'] ?? ucfirst($competencyKey) }}
                        </h4>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-white text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3 font-semibold w-12">No.</th>
                                    <th class="px-5 py-3 font-semibold">Indikator</th>
                                    <th class="px-5 py-3 font-semibold text-center w-28">Nilai</th>
                                    <th class="px-5 py-3 font-semibold">Catatan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100">
                                @foreach ($items as $detail)
                                    @php
                                        $indicator = $detail->indicator;
                                        $indicatorName = $indicator->name
                                            ?? $indicator->indicator
                                            ?? $indicator->description
                                            ?? 'Indikator tidak tersedia';
                                    @endphp

                                    <tr class="hover:bg-slate-50">
                                        <td class="px-5 py-4 text-slate-400">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td class="px-5 py-4">
                                            <p class="font-medium text-slate-800">
                                                {{ $indicatorName }}
                                            </p>
                                            @if (!empty($indicator?->code))
                                                <p class="text-xs text-slate-400 mt-1">
                                                    {{ $indicator->code }}
                                                </p>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 text-center">
                                            <span class="inline-flex min-w-14 justify-center rounded-lg px-3 py-2 font-bold
                                                {{ (float) $detail->score >= 80
                                                    ? 'bg-green-50 text-green-700'
                                                    : ((float) $detail->score >= 60
                                                        ? 'bg-blue-50 text-blue-700'
                                                        : 'bg-amber-50 text-amber-700') }}">
                                                {{ number_format((float) $detail->score, 2, ',', '.') }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4 text-slate-600">
                                            {{ $detail->notes ?: 'Tidak ada catatan' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate-500">
                    <i class="fa-solid fa-clipboard-list text-3xl mb-3"></i>
                    <p class="font-semibold">Belum ada rincian penilaian</p>
                    <p class="text-sm mt-1">
                        Data indikator belum tersedia untuk penilaian ini.
                    </p>
                </div>
            @endforelse
        </section>

        <div class="flex justify-end mb-8">
            <a href="{{ route('pengawas.assessments.edit', $assessment) }}"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700">
                <i class="fa-solid fa-pen-to-square"></i>
                Perbarui Penilaian
            </a>
        </div>

        <footer class="text-center text-xs text-slate-400 pb-5">
            SIMOGU &copy; {{ date('Y') }} — Sistem Informasi Guru
        </footer>
    </div>
</main>

</body>
</html>
