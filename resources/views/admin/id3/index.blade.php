
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelatihan Model ID3 - SIMOGU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="min-h-screen lg:ml-64">

        <header class="border-b border-slate-200 bg-white shadow-sm">
            <div class="flex flex-col gap-4 px-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <div class="flex items-start gap-3">
                    <div class="h-8 w-2 rounded-full bg-purple-600"></div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 sm:text-3xl">
                            Pelatihan Model ID3
                        </h1>
                        <p class="mt-1 text-sm text-slate-500">
                            Pengaturan batas nilai, pelabelan otomatis, pelatihan, dan evaluasi ID3.
                        </p>
                    </div>
                </div>

                <div class="text-left sm:text-right">
                    <p class="font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="mt-1 text-sm text-emerald-600">Administrator</p>
                </div>
            </div>
        </header>

        <section class="p-4 sm:p-6 lg:p-8">

            {{-- PESAN SUKSES --}}
            @if(session('success'))
                <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- PESAN ERROR --}}
            @if(session('error'))
                <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('training_error'))
                <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
                    <strong>Pelatihan gagal:</strong>
                    {{ session('training_error') }}
                </div>
            @endif

            @if(session('evaluation_error'))
                <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
                    <strong>Evaluasi gagal:</strong>
                    {{ session('evaluation_error') }}
                </div>
            @endif

            @if($errors->any())
                <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
                    <p class="mb-2 font-semibold">Periksa kembali input berikut:</p>
                    <ul class="list-inside list-disc space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- PENGATURAN BATAS NILAI --}}
            <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <h2 class="text-lg font-bold text-slate-800">
                    Pengaturan Batas Nilai Otomatis
                </h2>

                <p class="mb-5 mt-1 text-sm text-slate-500">
                    Batas ini digunakan untuk menentukan label berdasarkan nilai akhir penilaian.
                </p>

                <form id="thresholdForm" method="POST" action="{{ route('admin.id3.thresholds') }}">
                    @csrf

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                        <div>
                            <label for="batas_cukup" class="mb-2 block text-sm font-semibold text-slate-700">
                                Batas Cukup
                            </label>
                            <input
                                type="number"
                                id="batas_cukup"
                                name="batas_cukup"
                                min="0"
                                max="100"
                                step="0.01"
                                required
                                value="{{ old('batas_cukup', $thresholds['batas_cukup'] ?? 30) }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200"
                            >
                            <p class="mt-1 text-xs text-slate-500">Batas awal kategori Cukup.</p>
                        </div>

                        <div>
                            <label for="batas_baik" class="mb-2 block text-sm font-semibold text-slate-700">
                                Batas Baik
                            </label>
                            <input
                                type="number"
                                id="batas_baik"
                                name="batas_baik"
                                min="0"
                                max="100"
                                step="0.01"
                                required
                                value="{{ old('batas_baik', $thresholds['batas_baik'] ?? 60) }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200"
                            >
                            <p class="mt-1 text-xs text-slate-500">Batas awal kategori Baik.</p>
                        </div>

                        <div>
                            <label for="batas_sangat_baik" class="mb-2 block text-sm font-semibold text-slate-700">
                                Batas Sangat Baik
                            </label>
                            <input
                                type="number"
                                id="batas_sangat_baik"
                                name="batas_sangat_baik"
                                min="0"
                                max="100"
                                step="0.01"
                                required
                                value="{{ old('batas_sangat_baik', $thresholds['batas_sangat_baik'] ?? 80) }}"
                                class="w-full rounded-lg border border-slate-300 px-3 py-2.5 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200"
                            >
                            <p class="mt-1 text-xs text-slate-500">Batas awal kategori Sangat Baik.</p>
                        </div>

                    </div>

                    <div id="thresholdPreview" class="mt-5 rounded-xl border border-purple-100 bg-purple-50 p-4">
                        <p class="mb-2 font-semibold text-purple-900">
                            Pratinjau aturan label
                        </p>
                        <ul class="space-y-1 text-sm text-purple-800">
                            <li id="previewKurang">Kurang: nilai di bawah batas Cukup.</li>
                            <li id="previewCukup">Cukup: mulai batas Cukup hingga sebelum batas Baik.</li>
                            <li id="previewBaik">Baik: mulai batas Baik hingga sebelum batas Sangat Baik.</li>
                            <li id="previewSangatBaik">Sangat Baik: mulai batas Sangat Baik sampai 100.</li>
                        </ul>
                        <p id="thresholdWarning" class="mt-3 hidden text-sm font-semibold text-red-700"></p>
                    </div>

                    <button
                        type="submit"
                        class="mt-5 inline-flex items-center justify-center rounded-lg bg-purple-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-300"
                    >
                        Simpan Batas Nilai
                    </button>
                </form>

                <div class="mt-6 border-t border-slate-200 pt-5">
                    <h3 class="font-semibold text-slate-800">
                        Terapkan Label Otomatis
                    </h3>
                    <p class="mb-4 mt-1 text-sm text-slate-500">
                        Sinkronkan label untuk penilaian selesai yang memiliki seluruh nilai aspek, termasuk nilai dokumen.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.id3.sync-labels') }}"
                        onsubmit="return confirm('Sinkronkan label sesuai batas nilai yang tersimpan? Label yang tidak memenuhi syarat dataset juga dapat dihapus.');"
                    >
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-300"
                        >
                            Sinkronkan Label Otomatis
                        </button>
                    </form>
                </div>
            </div>

            {{-- DAFTAR PENILAIAN --}}
            <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="font-bold text-slate-800">Daftar Penilaian Selesai</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Label otomatis ditampilkan setelah proses sinkronisasi.
                        </p>
                    </div>

                    <span class="w-fit rounded-full bg-purple-50 px-3 py-1 text-sm font-semibold text-purple-700">
                        {{ $assessments->count() }} data
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[700px]">
                        <thead class="border-b border-slate-200 bg-slate-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-slate-500">ID</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-slate-500">Tanggal</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-slate-500">Nilai Akhir</th>
                                <th class="px-5 py-3 text-left text-xs font-bold uppercase text-slate-500">Label Otomatis</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">
                            @forelse($assessments as $assessment)
                                <tr class="transition hover:bg-slate-50">
                                    <td class="px-5 py-4 text-sm font-semibold text-slate-800">
                                        #{{ $assessment->id }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ $assessment->assessment_date
                                            ? \Carbon\Carbon::parse($assessment->assessment_date)->format('d-m-Y')
                                            : '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-slate-700">
                                        {{ $assessment->final_score !== null
                                            ? number_format((float) $assessment->final_score, 2, ',', '.')
                                            : '-' }}
                                    </td>

                                    <td class="px-5 py-4">
                                        @php
                                            $labelClass = match ($assessment->id3_label) {
                                                'Sangat Baik' => 'bg-emerald-100 text-emerald-700',
                                                'Baik' => 'bg-blue-100 text-blue-700',
                                                'Cukup' => 'bg-amber-100 text-amber-700',
                                                'Kurang' => 'bg-red-100 text-red-700',
                                                default => 'bg-slate-100 text-slate-600',
                                            };
                                        @endphp

                                        @if($assessment->id3_label)
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $labelClass }}">
                                                {{ $assessment->id3_label }}
                                            </span>
                                        @else
                                            <span class="text-sm text-slate-400">
                                                Belum disinkronkan
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-sm text-slate-500">
                                        Belum ada penilaian yang selesai.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- INFORMASI DATASET --}}
            <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-3">

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Status Dataset</p>
                    <p class="mt-2 text-xl font-bold {{ ($datasetInfo['available'] ?? false) ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ ($datasetInfo['available'] ?? false) ? 'Siap Digunakan' : 'Belum Siap' }}
                    </p>

                    @if(!($datasetInfo['available'] ?? false) && !empty($datasetInfo['error']))
                        <p class="mt-2 text-sm text-red-600">
                            {{ $datasetInfo['error'] }}
                        </p>
                    @endif
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Data Berlabel</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $datasetInfo['rows'] ?? 0 }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Penilaian lengkap yang memenuhi syarat ID3.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm text-slate-500">Jumlah Kelas</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ count($datasetInfo['classes'] ?? []) }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">Minimal dua kelas berbeda untuk pelatihan.</p>
                </div>
            </div>

            {{-- DISTRIBUSI KELAS --}}
            @if(!empty($datasetInfo['classes']))
                <div class="mb-8 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="border-b border-slate-200 px-5 py-4">
                        <h2 class="font-bold text-slate-800">Distribusi Kelas Dataset</h2>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase text-slate-500">Kelas</th>
                                    <th class="px-5 py-3 text-left text-xs font-bold uppercase text-slate-500">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($datasetInfo['classes'] as $class => $count)
                                    <tr>
                                        <td class="px-5 py-3 text-sm font-medium text-slate-800">
                                            {{ $class }}
                                        </td>
                                        <td class="px-5 py-3 text-sm text-slate-600">
                                            {{ $count }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- PELATIHAN DAN EVALUASI --}}
            <div class="mb-8 grid grid-cols-1 gap-6 xl:grid-cols-2">

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800">Pelatihan Model ID3</h2>
                    <p class="mb-5 mt-2 text-sm text-slate-500">
                        Bangun pohon keputusan berdasarkan data penilaian yang lengkap dan sudah memiliki label.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.id3.train') }}"
                        onsubmit="return confirm('Mulai pelatihan model ID3 menggunakan dataset saat ini?');"
                    >
                        @csrf
                        <button
                            type="submit"
                            @disabled(!($datasetInfo['available'] ?? false))
                            class="w-full rounded-lg bg-purple-600 px-5 py-3 font-semibold text-white transition hover:bg-purple-700 disabled:cursor-not-allowed disabled:bg-slate-300"
                        >
                            Mulai Pelatihan
                        </button>
                    </form>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-800">Evaluasi Model</h2>
                    <p class="mb-5 mt-2 text-sm text-slate-500">
                        Evaluasi performa model menggunakan evaluator ID3 yang tersedia.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('admin.id3.evaluate') }}"
                        onsubmit="return confirm('Mulai evaluasi model ID3 menggunakan dataset saat ini?');"
                    >
                        @csrf
                        <button
                            type="submit"
                            @disabled(!($datasetInfo['available'] ?? false))
                            class="w-full rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-slate-300"
                        >
                            Mulai Evaluasi
                        </button>
                    </form>
                </div>

            </div>

            {{-- HASIL PELATIHAN --}}
            @if(session('training_result'))
                @php
                    $training = session('training_result');
                @endphp

                <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-4 text-lg font-bold text-slate-800">Hasil Pelatihan</h2>

                    <div class="mb-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Jumlah Data</p>
                            <p class="mt-1 text-2xl font-bold text-slate-800">
                                {{ $training['rows'] ?? 0 }}
                            </p>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-sm text-slate-500">Jumlah Kelas</p>
                            <p class="mt-1 text-2xl font-bold text-slate-800">
                                {{ count($training['classes'] ?? []) }}
                            </p>
                        </div>
                    </div>

                    <h3 class="mb-3 font-semibold text-slate-800">Pohon Keputusan</h3>
                    <pre class="overflow-x-auto whitespace-pre-wrap break-words rounded-xl bg-slate-900 p-4 text-xs text-slate-100 sm:text-sm">{{ json_encode($training['tree'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            @endif

            {{-- HASIL EVALUASI --}}
            @if(session('evaluation_result'))
                @php
                    $evaluation = session('evaluation_result');

                    /*
                     * Mendukung metrik yang dikembalikan dalam rentang
                     * 0–1 maupun 0–100.
                     */
                    $formatPercent = function ($value) {
                        if (!is_numeric($value)) {
                            return '-';
                        }

                        $number = (float) $value;

                        if (abs($number) <= 1) {
                            $number *= 100;
                        }

                        return number_format($number, 2, ',', '.') . '%';
                    };

                    $metricValue = function (array $data, array $keys) {
                        foreach ($keys as $key) {
                            if (isset($data[$key]) && is_numeric($data[$key])) {
                                return $data[$key];
                            }
                        }

                        return null;
                    };

                    $perClass = $evaluation['per_class'] ?? [];
                    $confusionMatrix = $evaluation['confusion_matrix'] ?? [];
                @endphp

                <div class="mb-8 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-5 text-lg font-bold text-slate-800">Hasil Evaluasi Model</h2>

                    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach([
                            'Accuracy' => ['accuracy', 'accuracy_score'],
                            'Macro Precision' => ['macro_precision', 'precision_macro'],
                            'Macro Recall' => ['macro_recall', 'recall_macro'],
                            'Macro F1-Score' => ['macro_f1', 'macro_f1_score', 'f1_macro'],
                        ] as $label => $keys)
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <p class="text-sm text-slate-500">{{ $label }}</p>
                                <p class="mt-2 text-2xl font-bold text-slate-800">
                                    {{ $formatPercent($metricValue(is_array($evaluation) ? $evaluation : [], $keys)) }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    @if(is_array($perClass) && count($perClass))
                        <h3 class="mb-3 font-bold text-slate-800">Evaluasi Per Kelas</h3>

                        <div class="mb-8 overflow-x-auto">
                            <table class="w-full min-w-[600px]">
                                <thead class="bg-slate-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase text-slate-500">Kelas</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase text-slate-500">Precision</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase text-slate-500">Recall</th>
                                        <th class="px-4 py-3 text-left text-xs font-bold uppercase text-slate-500">F1-Score</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($perClass as $className => $metrics)
                                        @if(is_array($metrics))
                                            <tr>
                                                <td class="px-4 py-3 text-sm font-medium text-slate-800">
                                                    {{ is_numeric($className)
                                                        ? ($metrics['class'] ?? $metrics['label'] ?? 'Kelas ' . $loop->iteration)
                                                        : $className }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-600">
                                                    {{ $formatPercent($metricValue($metrics, ['precision'])) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-600">
                                                    {{ $formatPercent($metricValue($metrics, ['recall'])) }}
                                                </td>
                                                <td class="px-4 py-3 text-sm text-slate-600">
                                                    {{ $formatPercent($metricValue($metrics, ['f1', 'f1_score', 'f1-score'])) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if(is_array($confusionMatrix) && count($confusionMatrix))
                        <h3 class="mb-3 font-bold text-slate-800">Confusion Matrix</h3>

                        @php
                            $matrixIsNested = is_array(reset($confusionMatrix));
                            $matrixRows = $matrixIsNested ? $confusionMatrix : [];
                            $matrixColumns = $matrixIsNested && count($matrixRows)
                                ? array_keys((array) reset($matrixRows))
                                : [];
                        @endphp

                        @if($matrixIsNested && count($matrixColumns))
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[500px]">
                                    <thead class="bg-slate-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-bold uppercase text-slate-500">
                                                Aktual / Prediksi
                                            </th>
                                            @foreach($matrixColumns as $columnClass)
                                                <th class="px-4 py-3 text-left text-xs font-bold uppercase text-slate-500">
                                                    {{ $columnClass }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @foreach($matrixRows as $actualClass => $row)
                                            @if(is_array($row))
                                                <tr>
                                                    <td class="px-4 py-3 text-sm font-semibold text-slate-800">
                                                        {{ $actualClass }}
                                                    </td>
                                                    @foreach($matrixColumns as $columnClass)
                                                        <td class="px-4 py-3 text-sm text-slate-700">
                                                            {{ $row[$columnClass] ?? 0 }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <pre class="overflow-x-auto whitespace-pre-wrap break-words rounded-xl bg-slate-900 p-4 text-xs text-slate-100">{{ json_encode($confusionMatrix, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        @endif
                    @endif

                    @if(!isset($evaluation['accuracy']) && !isset($evaluation['accuracy_score']))
                        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-800">
                            Format hasil evaluasi berbeda dari format metrik yang dikenali oleh tampilan ini. Data hasil yang tersedia:
                            <pre class="mt-2 overflow-x-auto whitespace-pre-wrap break-words">{{ json_encode($evaluation, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    @endif
                </div>
            @endif

            <footer class="py-4 text-center text-sm text-slate-400">
                SIMOGU &copy; {{ date('Y') }} — Sistem Informasi Monitoring Guru
            </footer>

        </section>
    </main>

    <script>
        (() => {
            const form = document.getElementById('thresholdForm');

            if (!form) return;

            const cukup = document.getElementById('batas_cukup');
            const baik = document.getElementById('batas_baik');
            const sangatBaik = document.getElementById('batas_sangat_baik');
            const warning = document.getElementById('thresholdWarning');

            const previewKurang = document.getElementById('previewKurang');
            const previewCukup = document.getElementById('previewCukup');
            const previewBaik = document.getElementById('previewBaik');
            const previewSangatBaik = document.getElementById('previewSangatBaik');

            const number = (value) => Number(value).toLocaleString('id-ID', {
                maximumFractionDigits: 2
            });

            function updatePreview() {
                const c = Number(cukup.value);
                const b = Number(baik.value);
                const sb = Number(sangatBaik.value);

                const valid =
                    cukup.value !== '' &&
                    baik.value !== '' &&
                    sangatBaik.value !== '' &&
                    Number.isFinite(c) &&
                    Number.isFinite(b) &&
                    Number.isFinite(sb) &&
                    c >= 0 &&
                    sb <= 100 &&
                    c < b &&
                    b < sb;

                previewKurang.textContent =
                    `Kurang: nilai di bawah ${cukup.value === '' ? 'batas Cukup' : number(c)}.`;

                previewCukup.textContent =
                    `Cukup: ${cukup.value === '' ? 'batas Cukup' : number(c)} sampai sebelum ${baik.value === '' ? 'batas Baik' : number(b)}.`;

                previewBaik.textContent =
                    `Baik: ${baik.value === '' ? 'batas Baik' : number(b)} sampai sebelum ${sangatBaik.value === '' ? 'batas Sangat Baik' : number(sb)}.`;

                previewSangatBaik.textContent =
                    `Sangat Baik: mulai ${sangatBaik.value === '' ? 'batas Sangat Baik' : number(sb)} sampai 100.`;

                warning.classList.toggle('hidden', valid);
                warning.textContent = valid
                    ? ''
                    : 'Batas harus berupa angka 0–100 dengan urutan Batas Cukup < Batas Baik < Batas Sangat Baik.';
            }

            [cukup, baik, sangatBaik].forEach((input) => {
                input.addEventListener('input', updatePreview);
            });

            form.addEventListener('submit', (event) => {
                updatePreview();

                const c = Number(cukup.value);
                const b = Number(baik.value);
                const sb = Number(sangatBaik.value);

                if (
                    cukup.value === '' ||
                    baik.value === '' ||
                    sangatBaik.value === '' ||
                    !Number.isFinite(c) ||
                    !Number.isFinite(b) ||
                    !Number.isFinite(sb) ||
                    c < 0 ||
                    sb > 100 ||
                    c >= b ||
                    b >= sb
                ) {
                    event.preventDefault();
                    warning.classList.remove('hidden');
                    warning.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });

            updatePreview();
        })();
    </script>

</body>
</html>
