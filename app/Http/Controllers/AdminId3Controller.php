<?php

namespace App\Http\Controllers;

use App\Services\Id3Classifier;
use App\Services\Id3ModelEvaluator;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class AdminId3Controller extends Controller
{
    private string $target = 'kelas';

    /**
     * Kelas label yang digunakan oleh dataset ID3.
     */
    private array $allowedClasses = [
        'Kurang',
        'Cukup',
        'Baik',
        'Sangat Baik',
    ];

    /**
     * Batas label awal.
     */
    private function defaultThresholds(): array
    {
        return [
            'batas_cukup' => 30,
            'batas_baik' => 60,
            'batas_sangat_baik' => 80,
        ];
    }

    /**
     * Mengambil batas label dari database.
     */
    private function getThresholds(): array
    {
        $settings = DB::table('id3_settings')
            ->where('id', 1)
            ->first();

        if (!$settings) {
            return $this->defaultThresholds();
        }

        $thresholds = [
            'batas_cukup' => (float) $settings->batas_cukup,
            'batas_baik' => (float) $settings->batas_baik,
            'batas_sangat_baik' => (float) $settings->batas_sangat_baik,
        ];

        if (
            $thresholds['batas_cukup'] < 0 ||
            $thresholds['batas_baik'] > 100 ||
            $thresholds['batas_sangat_baik'] > 100 ||
            $thresholds['batas_cukup'] >= $thresholds['batas_baik'] ||
            $thresholds['batas_baik'] >= $thresholds['batas_sangat_baik']
        ) {
            throw new RuntimeException(
                'Konfigurasi batas label tidak valid. Periksa urutan batas nilai pada pengaturan ID3.'
            );
        }

        return $thresholds;
    }

    /**
     * Halaman utama pengaturan dan pelatihan ID3.
     */
    public function index(): View
    {
        $datasetInfo = [
            'available' => false,
            'rows' => 0,
            'classes' => [],
            'error' => null,
        ];

        $assessments = collect();
        $thresholds = $this->defaultThresholds();

        try {
            $thresholds = $this->getThresholds();

            $assessments = DB::table('assessments as a')
                ->leftJoin(
                    'id3_labels as l',
                    'l.assessment_id',
                    '=',
                    'a.id'
                )
                ->where('a.status', 'completed')
                ->select([
                    'a.id',
                    'a.assessment_date',
                    'a.final_score',
                    'a.classification',
                    'a.status',
                    'l.label as id3_label',
                ])
                ->orderByDesc('a.assessment_date')
                ->orderByDesc('a.id')
                ->get();

            $dataset = $this->loadDataset();
            $classes = $this->countClasses($dataset);

            $datasetInfo['rows'] = count($dataset);
            $datasetInfo['classes'] = $classes;
            $datasetInfo['available'] =
                count($dataset) >= 2 &&
                count($classes) >= 2;

            if (count($dataset) < 2) {
                $datasetInfo['error'] =
                    'Belum cukup data. Diperlukan minimal dua penilaian lengkap yang memiliki label ID3.';
            } elseif (count($classes) < 2) {
                $datasetInfo['error'] =
                    'Dataset harus memiliki minimal dua kelas label berbeda.';
            }
        } catch (Throwable $e) {
            report($e);

            $datasetInfo['error'] =
                'Dataset belum dapat dibaca. Periksa konfigurasi tabel, pengaturan batas label, dan data penilaian.';
        }

        return view('admin.id3.index', compact(
            'datasetInfo',
            'assessments',
            'thresholds'
        ));
    }

    /**
     * Menyimpan pengaturan batas label.
     */
    public function saveThresholds(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'batas_cukup' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'batas_baik' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
            'batas_sangat_baik' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],
        ]);

        if (
            (float) $validated['batas_cukup'] >=
                (float) $validated['batas_baik'] ||
            (float) $validated['batas_baik'] >=
                (float) $validated['batas_sangat_baik']
        ) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Batas nilai harus berurutan: batas Cukup < batas Baik < batas Sangat Baik.'
                );
        }

        try {
            DB::transaction(function () use ($validated) {
                $existing = DB::table('id3_settings')
                    ->where('id', 1)
                    ->first();

                $data = [
                    'batas_cukup' => $validated['batas_cukup'],
                    'batas_baik' => $validated['batas_baik'],
                    'batas_sangat_baik' => $validated['batas_sangat_baik'],
                    'updated_at' => now(),
                ];

                if ($existing) {
                    DB::table('id3_settings')
                        ->where('id', 1)
                        ->update($data);
                } else {
                    $data['id'] = 1;
                    $data['created_at'] = now();

                    DB::table('id3_settings')->insert($data);
                }
            });

            return redirect()
                ->route('admin.id3.index')
                ->with(
                    'success',
                    'Pengaturan batas nilai berhasil disimpan. Jalankan sinkronisasi label agar label mengikuti batas terbaru.'
                );
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Pengaturan batas nilai gagal disimpan.'
                );
        }
    }

    /**
     * Menyinkronkan label berdasarkan final_score.
     *
     * Label yang tidak valid hanya dihapus apabila penilaian
     * terkait memang tidak lagi memenuhi syarat dataset.
     */
    public function syncLabels(): RedirectResponse
    {
        try {
            $thresholds = $this->getThresholds();

            $assessments = DB::table('assessments as a')
                ->where('a.status', 'completed')
                ->whereNotNull('a.final_score')
                ->whereBetween('a.final_score', [0, 100])
                ->whereNotNull('a.pedagogik_score')
                ->whereBetween('a.pedagogik_score', [0, 100])
                ->whereNotNull('a.kepribadian_score')
                ->whereBetween('a.kepribadian_score', [0, 100])
                ->whereNotNull('a.sosial_score')
                ->whereBetween('a.sosial_score', [0, 100])
                ->whereNotNull('a.profesional_score')
                ->whereBetween('a.profesional_score', [0, 100])
                ->select('a.id', 'a.final_score')
                ->orderBy('a.id')
                ->get();

            $validIds = $assessments->pluck('id')->all();

            $created = 0;
            $updated = 0;
            $deleted = 0;

            DB::transaction(function () use (
                $assessments,
                $validIds,
                $thresholds,
                &$created,
                &$updated,
                &$deleted
            ) {
                $now = now();
                $userId = Auth::id();

                /*
                 * PENTING:
                 * Jika tidak ada ID valid, jangan menghapus semua label.
                 * Jika ada ID valid, hapus label yang assessment_id-nya
                 * tidak termasuk dalam daftar penilaian valid.
                 */
                if (!empty($validIds)) {
                    $deleted = DB::table('id3_labels')
                        ->whereNotIn('assessment_id', $validIds)
                        ->delete();
                }

                foreach ($assessments as $assessment) {
                    $score = (float) $assessment->final_score;

                    if ($score < $thresholds['batas_cukup']) {
                        $label = 'Kurang';
                    } elseif ($score < $thresholds['batas_baik']) {
                        $label = 'Cukup';
                    } elseif ($score < $thresholds['batas_sangat_baik']) {
                        $label = 'Baik';
                    } else {
                        $label = 'Sangat Baik';
                    }

                    $existing = DB::table('id3_labels')
                        ->where('assessment_id', $assessment->id)
                        ->first();

                    if ($existing) {
                        /*
                         * Perbarui label hanya jika kelas berubah.
                         * Dengan demikian, labeled_by tidak berubah
                         * tanpa kebutuhan.
                         */
                        if ($existing->label !== $label) {
                            DB::table('id3_labels')
                                ->where('assessment_id', $assessment->id)
                                ->update([
                                    'label' => $label,
                                    'labeled_by' => $userId,
                                    'updated_at' => $now,
                                ]);

                            $updated++;
                        }
                    } else {
                        DB::table('id3_labels')->insert([
                            'assessment_id' => $assessment->id,
                            'label' => $label,
                            'labeled_by' => $userId,
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);

                        $created++;
                    }
                }
            });

            return redirect()
                ->route('admin.id3.index')
                ->with(
                    'success',
                    "Sinkronisasi selesai: {$created} label baru dibuat, {$updated} label diperbarui, dan {$deleted} label tidak valid dihapus."
                );
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.id3.index')
                ->with(
                    'error',
                    'Sinkronisasi label gagal. Periksa konfigurasi tabel, pengaturan batas label, dan log aplikasi.'
                );
        }
    }

    /**
     * Melatih model ID3.
     */
    public function train(Id3Classifier $classifier): RedirectResponse
    {
        try {
            $dataset = $this->loadDataset();

            $this->validateTrainingDataset($dataset);

            $processed = $this->discretizeDataset($dataset);

            $tree = $classifier->train(
                $processed,
                $this->target
            );

            return redirect()
                ->route('admin.id3.index')
                ->with('training_result', [
                    'success' => true,
                    'rows' => count($processed),
                    'classes' => $this->countClasses($processed),
                    'tree' => $tree,
                ]);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.id3.index')
                ->with(
                    'training_error',
                    $e instanceof RuntimeException
                        ? $e->getMessage()
                        : 'Pelatihan ID3 gagal. Periksa data dan konfigurasi model.'
                );
        }
    }

    /**
     * Mengevaluasi model ID3.
     */
    public function evaluate(
        Id3ModelEvaluator $evaluator
    ): RedirectResponse {
        try {
            $dataset = $this->loadDataset();

            $this->validateTrainingDataset($dataset);

            $processed = $this->discretizeDataset($dataset);

            $result = $evaluator->evaluate(
                $processed,
                $this->target,
                2026
            );

            return redirect()
                ->route('admin.id3.index')
                ->with('evaluation_result', $result);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('admin.id3.index')
                ->with(
                    'evaluation_error',
                    $e instanceof RuntimeException
                        ? $e->getMessage()
                        : 'Evaluasi ID3 gagal. Periksa data dan konfigurasi evaluator.'
                );
        }
    }

    /**
     * Memuat dataset ID3 dari empat kompetensi.
     *
     * Catatan:
     * document_score belum digunakan sebagai fitur.
     * Label target berasal dari final_score sehingga perlu
     * diperhatikan risiko target leakage dalam interpretasi hasil.
     */
    private function loadDataset(): array
    {
        $rows = DB::table('assessments as a')
            ->join(
                'id3_labels as l',
                'l.assessment_id',
                '=',
                'a.id'
            )
            ->where('a.status', 'completed')
            ->whereNotNull('a.final_score')
            ->whereBetween('a.final_score', [0, 100])
            ->whereNotNull('a.pedagogik_score')
            ->whereBetween('a.pedagogik_score', [0, 100])
            ->whereNotNull('a.kepribadian_score')
            ->whereBetween('a.kepribadian_score', [0, 100])
            ->whereNotNull('a.sosial_score')
            ->whereBetween('a.sosial_score', [0, 100])
            ->whereNotNull('a.profesional_score')
            ->whereBetween('a.profesional_score', [0, 100])
            ->whereIn('l.label', $this->allowedClasses)
            ->select([
                'a.pedagogik_score',
                'a.kepribadian_score',
                'a.sosial_score',
                'a.profesional_score',
                'l.label as kelas',
            ])
            ->orderBy('a.id')
            ->get();

        $dataset = [];

        foreach ($rows as $row) {
            $dataset[] = [
                'Pedagogik' => (float) $row->pedagogik_score,
                'Kepribadian' => (float) $row->kepribadian_score,
                'Sosial' => (float) $row->sosial_score,
                'Profesional' => (float) $row->profesional_score,
                'kelas' => (string) $row->kelas,
            ];
        }

        return $dataset;
    }

    /**
     * Memastikan dataset memenuhi syarat dasar ID3.
     */
    private function validateTrainingDataset(array $dataset): void
    {
        if (count($dataset) < 2) {
            throw new RuntimeException(
                'Data pelatihan belum cukup. Diperlukan minimal dua penilaian completed yang sudah memiliki label ID3 dan nilai empat kompetensi.'
            );
        }

        $classes = $this->countClasses($dataset);

        if (count($classes) < 2) {
            throw new RuntimeException(
                'Dataset harus memiliki minimal dua kelas label berbeda.'
            );
        }
    }

    /**
     * Mengubah nilai numerik empat kompetensi menjadi kategori.
     */
    private function discretizeDataset(array $dataset): array
    {
        $features = [
            'Pedagogik',
            'Kepribadian',
            'Sosial',
            'Profesional',
        ];

        foreach ($dataset as &$row) {
            foreach ($features as $column) {
                if (!array_key_exists($column, $row)) {
                    throw new RuntimeException(
                        "Fitur {$column} tidak ditemukan pada dataset."
                    );
                }

                if (!is_numeric($row[$column])) {
                    throw new RuntimeException(
                        "Nilai fitur {$column} harus berupa angka."
                    );
                }

                $score = (float) $row[$column];

                if ($score < 0 || $score > 100) {
                    throw new RuntimeException(
                        "Nilai fitur {$column} harus berada di antara 0 sampai 100."
                    );
                }

                if ($score < 60) {
                    $row[$column] = 'Rendah';
                } elseif ($score < 70) {
                    $row[$column] = 'Cukup Rendah';
                } elseif ($score < 80) {
                    $row[$column] = 'Sedang';
                } elseif ($score < 90) {
                    $row[$column] = 'Tinggi';
                } else {
                    $row[$column] = 'Sangat Tinggi';
                }
            }

            if (
                !isset($row[$this->target]) ||
                !in_array(
                    $row[$this->target],
                    $this->allowedClasses,
                    true
                )
            ) {
                throw new RuntimeException(
                    'Label target tidak ditemukan atau tidak sesuai dengan kelas ID3 yang diizinkan.'
                );
            }
        }

        unset($row);

        return $dataset;
    }

    /**
     * Menghitung jumlah data untuk setiap kelas.
     */
    private function countClasses(array $dataset): array
    {
        $counts = [];

        foreach ($dataset as $row) {
            if (!isset($row[$this->target])) {
                continue;
            }

            $class = (string) $row[$this->target];

            $counts[$class] = ($counts[$class] ?? 0) + 1;
        }

        ksort($counts);

        return $counts;
    }
}
