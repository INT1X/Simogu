<?php

namespace App\Services;

use InvalidArgumentException;

class Id3ModelEvaluator
{
    /**
     * Kelas label harus sama dengan label yang dibuat
     * oleh AdminId3Controller.
     */
    private array $classes = [
        'Kurang',
        'Cukup',
        'Baik',
        'Sangat Baik',
    ];

    /**
     * Evaluasi model ID3 menggunakan pembagian data 80:20.
     *
     * Setiap indikator numerik diubah menjadi kategori
     * sebelum pelatihan agar ID3 tidak membuat cabang
     * untuk setiap nilai angka.
     */
    public function evaluate(
        array $dataset,
        string $target = 'kelas',
        int $seed = 2026
    ): array {
        if (count($dataset) < 5) {
            throw new InvalidArgumentException(
                'Dataset minimal harus berisi 5 baris.'
            );
        }

        /*
         * Pastikan setiap baris memiliki kolom target.
         */
        foreach ($dataset as $index => $row) {
            if (!is_array($row) || !array_key_exists($target, $row)) {
                throw new InvalidArgumentException(
                    "Kolom target '{$target}' tidak ditemukan pada baris "
                    . ($index + 1) . '.'
                );
            }
        }

        /*
         * Hilangkan baris yang tidak memiliki label.
         */
        $dataset = array_values(array_filter(
            $dataset,
            fn ($row) =>
                isset($row[$target]) &&
                trim((string) $row[$target]) !== ''
        ));

        if (count($dataset) < 5) {
            throw new InvalidArgumentException(
                'Dataset valid minimal harus berisi 5 baris.'
            );
        }

        /*
         * Pastikan nama fitur konsisten.
         */
        $features = array_values(array_filter(
            array_keys($dataset[0]),
            fn ($column) => $column !== $target
        ));

        if (empty($features)) {
            throw new InvalidArgumentException(
                'Dataset tidak memiliki kolom indikator.'
            );
        }

        /*
         * Validasi seluruh fitur dan label.
         */
        foreach ($dataset as $index => $row) {
            foreach ($features as $feature) {
                if (!array_key_exists($feature, $row)) {
                    throw new InvalidArgumentException(
                        "Kolom indikator '{$feature}' tidak konsisten "
                        . 'pada baris ' . ($index + 1) . '.'
                    );
                }

                if (
                    !is_numeric($row[$feature]) ||
                    !is_finite((float) $row[$feature])
                ) {
                    throw new InvalidArgumentException(
                        "Nilai indikator '{$feature}' harus berupa angka valid."
                    );
                }

                $score = (float) $row[$feature];

                if ($score < 0 || $score > 100) {
                    throw new InvalidArgumentException(
                        "Nilai indikator '{$feature}' harus berada "
                        . 'di antara 0 sampai 100.'
                    );
                }
            }

            $label = trim((string) $row[$target]);

            if (!in_array($label, $this->classes, true)) {
                throw new InvalidArgumentException(
                    "Label '{$label}' tidak dikenal. "
                    . 'Label yang diizinkan: '
                    . implode(', ', $this->classes) . '.'
                );
            }

            $dataset[$index][$target] = $label;
        }

        /*
         * Pastikan dataset memiliki minimal dua kelas.
         */
        $uniqueClasses = array_unique(
            array_column($dataset, $target)
        );

        if (count($uniqueClasses) < 2) {
            throw new InvalidArgumentException(
                'Evaluasi memerlukan minimal dua kelas label berbeda.'
            );
        }

        /*
         * Diskretisasi menggunakan batas kategori tetap.
         * Karena batas telah ditentukan sebelumnya, proses ini
         * tidak mempelajari parameter dari data uji.
         */
        $dataset = array_map(
            function ($row) use ($features, $target) {
                foreach ($features as $feature) {
                    $score = (float) $row[$feature];

                    if ($score < 60) {
                        $row[$feature] = 'Rendah';
                    } elseif ($score < 70) {
                        $row[$feature] = 'Cukup Rendah';
                    } elseif ($score < 80) {
                        $row[$feature] = 'Sedang';
                    } elseif ($score < 90) {
                        $row[$feature] = 'Tinggi';
                    } else {
                        $row[$feature] = 'Sangat Tinggi';
                    }
                }

                $row[$target] = trim((string) $row[$target]);

                return $row;
            },
            $dataset
        );

        /*
         * Pembagian data 80:20 yang dapat direproduksi.
         */
        mt_srand($seed);
        shuffle($dataset);

        $testCount = max(
            1,
            min(
                count($dataset) - 1,
                (int) round(count($dataset) * 0.20)
            )
        );

        $testData = array_slice($dataset, 0, $testCount);
        $trainData = array_slice($dataset, $testCount);

        if (empty($trainData) || empty($testData)) {
            throw new InvalidArgumentException(
                'Pembagian data latih dan data uji tidak dapat dilakukan.'
            );
        }

        /*
         * Latih model hanya menggunakan data latih.
         */
        $id3 = new Id3Classifier();

        $tree = $id3->train(
            $trainData,
            $target
        );

        /*
         * Inisialisasi confusion matrix.
         * Baris = kelas aktual, kolom = kelas prediksi.
         */
        $matrix = [];

        foreach ($this->classes as $actual) {
            foreach ($this->classes as $predicted) {
                $matrix[$actual][$predicted] = 0;
            }
        }

        $correct = 0;

        /*
         * Evaluasi prediksi pada data uji.
         */
        foreach ($testData as $row) {
            $actual = (string) $row[$target];

            $sample = $row;
            unset($sample[$target]);

            $predicted = (string) $id3->predict(
                $tree,
                $sample
            );

            /*
             * Prediksi seharusnya berasal dari kelas pada data latih.
             * Jika tidak, hentikan evaluasi agar metrik tidak keliru.
             */
            if (!in_array($predicted, $this->classes, true)) {
                throw new InvalidArgumentException(
                    "Model menghasilkan kelas prediksi tidak dikenal: "
                    . $predicted
                );
            }

            $matrix[$actual][$predicted]++;

            if ($actual === $predicted) {
                $correct++;
            }
        }

        /*
         * Hitung accuracy.
         */
        $accuracy = $correct / count($testData);

        /*
         * Hitung precision, recall, F1-score, dan support
         * untuk setiap kelas standar.
         */
        $perClass = [];

        $precisionSum = 0.0;
        $recallSum = 0.0;
        $f1Sum = 0.0;

        foreach ($this->classes as $class) {
            $tp = $matrix[$class][$class];

            $fp = 0;
            $fn = 0;
            $support = 0;

            /*
             * False positive:
             * diprediksi sebagai kelas ini, padahal aktualnya berbeda.
             *
             * False negative:
             * aktualnya kelas ini, tetapi diprediksi sebagai kelas lain.
             */
            foreach ($this->classes as $otherClass) {
                $support += $matrix[$class][$otherClass];

                if ($otherClass !== $class) {
                    $fp += $matrix[$otherClass][$class];
                    $fn += $matrix[$class][$otherClass];
                }
            }

            $precision = ($tp + $fp) > 0
                ? $tp / ($tp + $fp)
                : 0.0;

            $recall = ($tp + $fn) > 0
                ? $tp / ($tp + $fn)
                : 0.0;

            $f1 = ($precision + $recall) > 0
                ? 2 * $precision * $recall
                    / ($precision + $recall)
                : 0.0;

            $perClass[$class] = [
                'precision' => round($precision, 4),
                'recall' => round($recall, 4),
                'f1_score' => round($f1, 4),
                'support' => $support,
            ];

            $precisionSum += $precision;
            $recallSum += $recall;
            $f1Sum += $f1;
        }

        /*
         * Macro average menghitung rata-rata seluruh kelas standar.
         * Kelas yang tidak memiliki prediksi atau data aktual
         * tetap mendapat nilai nol untuk metrik terkait.
         */
        $classCount = count($this->classes);

        return [
            'train_count' => count($trainData),
            'test_count' => count($testData),
            'correct' => $correct,

            'accuracy' => round($accuracy, 4),
            'accuracy_percent' => round($accuracy * 100, 2),

            'macro_precision' => round(
                $precisionSum / $classCount,
                4
            ),

            'macro_recall' => round(
                $recallSum / $classCount,
                4
            ),

            'macro_f1_score' => round(
                $f1Sum / $classCount,
                4
            ),

            'per_class' => $perClass,
            'confusion_matrix' => $matrix,
            'tree' => $tree,

            'preprocessing' => [
                'method' => 'Diskretisasi skor indikator',
                'categories' => [
                    '0-59' => 'Rendah',
                    '60-69' => 'Cukup Rendah',
                    '70-79' => 'Sedang',
                    '80-89' => 'Tinggi',
                    '90-100' => 'Sangat Tinggi',
                ],
            ],

            'warning' =>
                'Evaluasi menggunakan label yang dibentuk berdasarkan '
                . 'final_score, bukan label independen dari penilai resmi. '
                . 'Karena itu, hasil evaluasi belum membuktikan kemampuan '
                . 'prediksi pada penilaian guru baru. Selain itu, apabila '
                . 'label ditentukan dari skor yang juga menjadi sumber '
                . 'fitur, terdapat risiko target leakage.',
        ];
    }
}
