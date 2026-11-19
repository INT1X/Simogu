<?php

namespace App\Console\Commands;

use App\Models\AssessmentWeight;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use RuntimeException;

class GenerateId3Dataset extends Command
{
    protected $signature = 'id3:generate-dataset
                            {--rows=80 : Jumlah data simulasi}
                            {--seed=2026 : Seed agar dataset dapat dibuat ulang}';

    protected $description =
        'Membuat dataset simulasi ID3 berdasarkan empat kompetensi guru';

    public function handle(): int
    {
        $rowCount = (int) $this->option('rows');
        $seed = (int) $this->option('seed');

        if ($rowCount < 20) {
            $this->error('Jumlah data minimal 20 baris.');
            return self::FAILURE;
        }

        if ($seed < 0) {
            $this->error('Seed tidak boleh negatif.');
            return self::FAILURE;
        }

        $competencies = [
            'Pedagogik' => 'pedagogik_score',
            'Kepribadian' => 'kepribadian_score',
            'Sosial' => 'sosial_score',
            'Profesional' => 'profesional_score',
        ];

        $weights = AssessmentWeight::where('is_active', true)
            ->get()
            ->keyBy('competency');

        $totalWeight = 0.0;

        foreach ($competencies as $competency => $column) {
            if (!$weights->has($competency)) {
                $this->error("Bobot aktif {$competency} tidak ditemukan.");
                return self::FAILURE;
            }

            $weight = (float) $weights[$competency]->weight;

            if (!is_finite($weight) || $weight < 0) {
                $this->error("Bobot {$competency} tidak valid.");
                return self::FAILURE;
            }

            $totalWeight += $weight;
        }

        if ($totalWeight <= 0) {
            $this->error('Total bobot kompetensi harus lebih besar dari nol.');
            return self::FAILURE;
        }

        try {
            $settings = DB::table('id3_settings')
                ->where('id', 1)
                ->first();

            $thresholds = [
                'batas_cukup' => (float) ($settings->batas_cukup ?? 30),
                'batas_baik' => (float) ($settings->batas_baik ?? 60),
                'batas_sangat_baik' => (float) ($settings->batas_sangat_baik ?? 80),
            ];

            if (
                $thresholds['batas_cukup'] < 0 ||
                $thresholds['batas_sangat_baik'] > 100 ||
                $thresholds['batas_cukup'] >= $thresholds['batas_baik'] ||
                $thresholds['batas_baik'] >= $thresholds['batas_sangat_baik']
            ) {
                throw new RuntimeException(
                    'Konfigurasi batas nilai ID3 tidak valid.'
                );
            }
        } catch (\Throwable $e) {
            $this->error('Gagal membaca konfigurasi ID3: ' . $e->getMessage());
            return self::FAILURE;
        }

        mt_srand($seed);

        $directory = storage_path('app/datasets');
        File::ensureDirectoryExists($directory);

        $path = $directory . '/id3_dataset_simulasi.csv';
        $temporaryPath = $path . '.tmp';

        $handle = fopen($temporaryPath, 'w');

        if ($handle === false) {
            $this->error('Gagal membuat file dataset sementara.');
            return self::FAILURE;
        }

        $classes = [
            'Kurang',
            'Cukup',
            'Baik',
            'Sangat Baik',
        ];

        $classCounts = array_fill_keys($classes, 0);

        try {
            // BOM UTF-8 untuk kompatibilitas Excel.
            fwrite($handle, "\xEF\xBB\xBF");

            $headers = array_values($competencies);
            $headers[] = 'kelas';

            fputcsv($handle, $headers, ';');

            for ($i = 0; $i < $rowCount; $i++) {
                // Nilai dasar dibuat bervariasi dan dapat direproduksi.
                $overall = mt_rand(0, 10000) / 100;

                $row = [];
                $competencyScores = [];

                foreach ($competencies as $competency => $column) {
                    $score = max(
                        0,
                        min(100, $overall + mt_rand(-1200, 1200) / 100)
                    );

                    $score = round($score, 2);

                    $row[$column] = $score;
                    $competencyScores[$competency] = $score;
                }

                // Hitung nilai akhir menggunakan bobot aktif SIMOGU.
                $finalScore = 0.0;

                foreach ($competencies as $competency => $column) {
                    $weight = (float) $weights[$competency]->weight;

                    $finalScore +=
                        $competencyScores[$competency] *
                        ($weight / $totalWeight);
                }

                $finalScore = round($finalScore, 2);

                // Gunakan aturan label yang sama dengan controller.
                if ($finalScore < $thresholds['batas_cukup']) {
                    $class = 'Kurang';
                } elseif ($finalScore < $thresholds['batas_baik']) {
                    $class = 'Cukup';
                } elseif ($finalScore < $thresholds['batas_sangat_baik']) {
                    $class = 'Baik';
                } else {
                    $class = 'Sangat Baik';
                }

                $csvRow = array_values($row);
                $csvRow[] = $class;

                if (fputcsv($handle, $csvRow, ';') === false) {
                    throw new RuntimeException('Gagal menulis baris dataset.');
                }

                $classCounts[$class]++;
            }
        } catch (\Throwable $e) {
            fclose($handle);
            File::delete($temporaryPath);

            $this->error('Pembuatan dataset gagal: ' . $e->getMessage());

            return self::FAILURE;
        }

        fclose($handle);

        if (!@rename($temporaryPath, $path)) {
            File::delete($temporaryPath);

            $this->error('Gagal menyimpan dataset final.');
            return self::FAILURE;
        }

        $this->info('Dataset simulasi berhasil dibuat.');
        $this->line("Lokasi: {$path}");
        $this->line("Jumlah data: {$rowCount}");
        $this->line('Jumlah fitur: ' . count($competencies));
        $this->line("Seed: {$seed}");

        $this->newLine();
        $this->info('Distribusi kelas:');

        foreach ($classCounts as $class => $count) {
            $this->line("{$class}: {$count}");
        }

        $this->newLine();

        $this->warn(
            'Dataset ini merupakan data sintetis. Label dibentuk dari nilai akhir '
            . 'berbobot dan bukan hasil penilaian ahli independen.'
        );

        return self::SUCCESS;
    }
}
