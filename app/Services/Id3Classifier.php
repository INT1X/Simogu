<?php

namespace App\Services;

use InvalidArgumentException;

class Id3Classifier
{
    /**
     * Melatih pohon keputusan ID3.
     *
     * Contoh dataset:
     * [
     *     ['disiplin' => 'Tinggi', 'kelas' => 'Baik'],
     *     ['disiplin' => 'Rendah', 'kelas' => 'Kurang'],
     * ]
     *
     * $target adalah nama kolom label.
     */
    public function train(array $dataset, string $target): array
    {
        if (empty($dataset)) {
            throw new InvalidArgumentException(
                'Dataset pelatihan tidak boleh kosong.'
            );
        }

        $dataset = array_values($dataset);

        foreach ($dataset as $index => $row) {
            if (!is_array($row)) {
                throw new InvalidArgumentException(
                    'Setiap baris dataset harus berupa array.'
                );
            }

            if (!array_key_exists($target, $row)) {
                throw new InvalidArgumentException(
                    "Kolom target '{$target}' tidak ditemukan pada baris "
                    . ($index + 1) . '.'
                );
            }

            if (
                $row[$target] === null ||
                trim((string) $row[$target]) === ''
            ) {
                throw new InvalidArgumentException(
                    'Label target tidak boleh kosong pada baris '
                    . ($index + 1) . '.'
                );
            }
        }

        /*
         * Pastikan struktur kolom konsisten pada setiap baris.
         */
        $columns = array_keys($dataset[0]);

        foreach ($dataset as $index => $row) {
            foreach ($columns as $column) {
                if (!array_key_exists($column, $row)) {
                    throw new InvalidArgumentException(
                        "Kolom '{$column}' tidak konsisten pada baris "
                        . ($index + 1) . '.'
                    );
                }
            }
        }

        $features = array_values(
            array_filter(
                $columns,
                fn ($column) => $column !== $target
            )
        );

        /*
         * Pohon satu kelas tetap valid meskipun tidak memiliki fitur.
         */
        if (empty($features)) {
            $labels = array_map(
                fn ($row) => (string) $row[$target],
                $dataset
            );

            $counts = array_count_values($labels);
            $majorityClass = $this->getMajorityClass($counts);

            if (count($counts) === 1) {
                return ['class' => $majorityClass];
            }

            throw new InvalidArgumentException(
                'Dataset harus memiliki minimal satu fitur untuk '
                . 'memisahkan kelas yang berbeda.'
            );
        }

        return $this->buildTree(
            $dataset,
            $features,
            $target
        );
    }

    /**
     * Menghitung entropy dari distribusi kelas.
     */
    public function entropy(array $labels): float
    {
        if (empty($labels)) {
            return 0.0;
        }

        $labels = array_map(
            fn ($label) => (string) $label,
            $labels
        );

        $counts = array_count_values($labels);
        $total = count($labels);
        $entropy = 0.0;

        foreach ($counts as $count) {
            $probability = $count / $total;

            if ($probability > 0) {
                $entropy -= $probability * log($probability, 2);
            }
        }

        return $entropy;
    }

    /**
     * Menghitung information gain suatu atribut.
     */
    public function informationGain(
        array $dataset,
        string $feature,
        string $target
    ): float {
        if (empty($dataset)) {
            return 0.0;
        }

        foreach ($dataset as $index => $row) {
            if (
                !array_key_exists($feature, $row) ||
                !array_key_exists($target, $row)
            ) {
                throw new InvalidArgumentException(
                    "Kolom '{$feature}' atau '{$target}' tidak ditemukan "
                    . 'pada baris ' . ($index + 1) . '.'
                );
            }

            if ($row[$target] === null) {
                throw new InvalidArgumentException(
                    'Label target tidak boleh null.'
                );
            }
        }

        $labels = array_map(
            fn ($row) => (string) $row[$target],
            $dataset
        );

        $baseEntropy = $this->entropy($labels);
        $groups = [];

        foreach ($dataset as $row) {
            $value = (string) $row[$feature];
            $groups[$value][] = $row;
        }

        $weightedEntropy = 0.0;
        $total = count($dataset);

        foreach ($groups as $group) {
            $groupLabels = array_map(
                fn ($row) => (string) $row[$target],
                $group
            );

            $weightedEntropy +=
                (count($group) / $total) *
                $this->entropy($groupLabels);
        }

        return max(0.0, $baseEntropy - $weightedEntropy);
    }

    /**
     * Memprediksi kelas dari satu sampel.
     */
    public function predict(array $tree, array $sample): string
    {
        while (isset($tree['feature'])) {
            $feature = $tree['feature'];

            /*
             * Jika fitur tidak tersedia atau cabangnya tidak dikenal,
             * gunakan kelas mayoritas pada node tersebut.
             */
            if (!array_key_exists($feature, $sample)) {
                return (string) $tree['default'];
            }

            $value = (string) $sample[$feature];

            if (
                !isset($tree['branches']) ||
                !array_key_exists($value, $tree['branches'])
            ) {
                return (string) $tree['default'];
            }

            $tree = $tree['branches'][$value];
        }

        if (!isset($tree['class'])) {
            throw new InvalidArgumentException(
                'Struktur pohon keputusan tidak valid.'
            );
        }

        return (string) $tree['class'];
    }

    /**
     * Memilih kelas mayoritas secara deterministik.
     *
     * Jika jumlah kelas sama, kelas yang muncul lebih dahulu
     * dalam urutan label yang diurutkan secara alfabetis dipilih.
     */
    private function getMajorityClass(array $counts): string
    {
        if (empty($counts)) {
            throw new InvalidArgumentException(
                'Tidak dapat menentukan kelas mayoritas dari data kosong.'
            );
        }

        ksort($counts, SORT_STRING);

        $maximum = max($counts);

        foreach ($counts as $class => $count) {
            if ($count === $maximum) {
                return (string) $class;
            }
        }

        throw new InvalidArgumentException(
            'Kelas mayoritas tidak dapat ditentukan.'
        );
    }

    /**
     * Membentuk pohon keputusan secara rekursif.
     */
    private function buildTree(
        array $dataset,
        array $features,
        string $target
    ): array {
        if (empty($dataset)) {
            throw new InvalidArgumentException(
                'Data pada node pohon tidak boleh kosong.'
            );
        }

        $labels = array_map(
            fn ($row) => (string) $row[$target],
            $dataset
        );

        $counts = array_count_values($labels);
        $majorityClass = $this->getMajorityClass($counts);

        /*
         * Jika seluruh data memiliki kelas yang sama,
         * node menjadi leaf.
         */
        if (count($counts) === 1) {
            return ['class' => $majorityClass];
        }

        /*
         * Jika tidak ada atribut tersisa,
         * gunakan kelas mayoritas.
         */
        if (empty($features)) {
            return ['class' => $majorityClass];
        }

        $bestFeature = null;
        $bestGain = 0.0;

        foreach ($features as $feature) {
            $gain = $this->informationGain(
                $dataset,
                $feature,
                $target
            );

            /*
             * Perbandingan ketat mempertahankan urutan fitur
             * awal apabila information gain sama.
             */
            if ($gain > $bestGain) {
                $bestGain = $gain;
                $bestFeature = $feature;
            }
        }

        /*
         * Tidak ada atribut yang memberikan information gain
         * positif: jadikan node sebagai leaf.
         */
        if ($bestFeature === null || $bestGain <= 0.0) {
            return ['class' => $majorityClass];
        }

        /*
         * Kelompokkan data berdasarkan nilai fitur terbaik.
         */
        $branches = [];

        foreach ($dataset as $row) {
            $value = (string) $row[$bestFeature];
            $branches[$value][] = $row;
        }

        /*
         * Fitur yang sudah digunakan tidak digunakan kembali
         * pada cabang turunannya.
         */
        $remainingFeatures = array_values(
            array_filter(
                $features,
                fn ($feature) => $feature !== $bestFeature
            )
        );

        $nodes = [];

        foreach ($branches as $value => $rows) {
            $nodes[$value] = $this->buildTree(
                $rows,
                $remainingFeatures,
                $target
            );
        }

        return [
            'feature' => $bestFeature,
            'gain' => $bestGain,
            'default' => $majorityClass,
            'branches' => $nodes,
        ];
    }
}
