
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Hasil Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >
</head>

<body class="bg-slate-100 min-h-screen">

    @include('components.guru-sidebar')

    <main class="md:ml-72 min-h-screen">

        <header class="sticky top-0 z-30 bg-white border-b border-slate-200">
            <div class="px-6 py-4">
                <h1 class="text-xl font-bold text-slate-800">
                    Hasil Penilaian
                </h1>

                <p class="text-sm text-slate-500">
                    Hasil penilaian kinerja Anda
                </p>
            </div>
        </header>

        <div class="p-6">

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

                <h2 class="text-lg font-bold text-slate-800 mb-5">
                    {{ $teacher->name }}
                </h2>

                {{-- Pilihan periode penilaian --}}
                <div class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-4">

                    <form method="GET" action="{{ url()->current() }}">

                        <label
                            for="period"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            <i class="fa-solid fa-calendar-days mr-2"></i>
                            Periode Penilaian
                        </label>

                        <div class="flex flex-col sm:flex-row gap-3">

                            <select
                                name="period"
                                id="period"
                                class="w-full sm:max-w-md rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-200"
                            >
                                @if($periods->isEmpty())
                                    <option value="">
                                        Belum ada periode penilaian
                                    </option>
                                @else
                                    @foreach($periods as $period)
                                        <option
                                            value="{{ $period->id }}"
                                            @selected(
                                                $selectedPeriod
                                                && (int) $selectedPeriod->id === (int) $period->id
                                            )
                                        >
                                            {{ $period->name }}
                                            @if(
                                                $activePeriod
                                                && (int) $activePeriod->id === (int) $period->id
                                            )
                                                (Aktif)
                                            @endif
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                <i class="fa-solid fa-filter"></i>
                                Tampilkan
                            </button>

                        </div>
                    </form>

                    @if($selectedPeriod)
                        <p class="mt-3 text-sm text-slate-600">
                            Periode yang ditampilkan:
                            <span class="font-semibold text-slate-800">
                                {{ $selectedPeriod->name }}
                            </span>

                            @if(
                                $activePeriod
                                && (int) $selectedPeriod->id === (int) $activePeriod->id
                            )
                                <span class="ml-1 inline-flex items-center rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                    Periode Aktif
                                </span>
                            @endif
                        </p>
                    @else
                        <p class="mt-3 text-sm text-amber-700">
                            Belum ada periode penilaian aktif. Silakan hubungi administrator.
                        </p>
                    @endif

                </div>

                {{-- Hasil penilaian --}}
                @if($assessments->isEmpty())

                    <div class="text-center py-12">

                        <i class="fa-solid fa-clipboard-check text-4xl text-slate-300 mb-4"></i>

                        <h3 class="text-lg font-semibold text-slate-700">
                            Belum Ada Hasil Penilaian
                        </h3>

                        <p class="text-sm text-slate-500 mt-2">
                            @if($selectedPeriod)
                                Belum ada hasil penilaian untuk periode
                                {{ $selectedPeriod->name }}.
                            @else
                                Belum tersedia hasil penilaian untuk ditampilkan.
                            @endif
                        </p>

                    </div>

                @else

                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="font-semibold text-slate-800">
                            Daftar Hasil Penilaian
                        </h3>

                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                            {{ $assessments->count() }} penilaian
                        </span>
                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50">
                                    <th class="text-left py-3 px-3 font-semibold text-slate-600">
                                        Tanggal
                                    </th>

                                    <th class="text-left py-3 px-3 font-semibold text-slate-600">
                                        Pengawas
                                    </th>

                                    <th class="text-left py-3 px-3 font-semibold text-slate-600">
                                        Nilai Akhir
                                    </th>

                                    <th class="text-left py-3 px-3 font-semibold text-slate-600">
                                        Klasifikasi
                                    </th>

                                    <th class="text-left py-3 px-3 font-semibold text-slate-600">
                                        Status
                                    </th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($assessments as $assessment)

                                    <tr class="border-b border-slate-100 hover:bg-slate-50">

                                        <td class="py-3 px-3 text-slate-600 whitespace-nowrap">
                                            {{ $assessment->assessment_date?->format('d-m-Y') ?? '-' }}
                                        </td>

                                        <td class="py-3 px-3 text-slate-700">
                                            {{ $assessment->supervisor?->name ?? '-' }}
                                        </td>

                                        <td class="py-3 px-3 font-semibold text-slate-800">
                                            {{ number_format((float) $assessment->final_score, 2) }}
                                        </td>

                                        <td class="py-3 px-3 text-slate-600">
                                            {{ $assessment->classification ?? '-' }}
                                        </td>

                                        <td class="py-3 px-3">
                                            @php
                                                $status = strtolower($assessment->status ?? '');
                                            @endphp

                                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold
                                                {{ in_array($status, ['selesai', 'completed']) ? 'bg-green-100 text-green-700' : ($status === 'draft' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                                {{ ucfirst($assessment->status ?? '-') }}
                                            </span>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

        </div>

    </main>

</body>
</html>
