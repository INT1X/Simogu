<?php

namespace Database\Seeders;

use App\Models\AssessmentIndicator;
use Illuminate\Database\Seeder;

class AssessmentIndicatorSeeder extends Seeder
{
    public function run(): void
    {
        $indicators = [

            /*
            |--------------------------------------------------------------------------
            | PEDAGOGIK
            |--------------------------------------------------------------------------
            */

            [
                'code' => 'PED-01',
                'competency' => 'Pedagogik',
                'name' => 'Perencanaan Pembelajaran',
                'description' => 'Kemampuan guru dalam menyusun perencanaan pembelajaran.',
                'weight' => 25,
                'is_active' => true,
            ],

            [
                'code' => 'PED-02',
                'competency' => 'Pedagogik',
                'name' => 'Pelaksanaan Pembelajaran',
                'description' => 'Kemampuan guru dalam melaksanakan proses pembelajaran.',
                'weight' => 30,
                'is_active' => true,
            ],

            [
                'code' => 'PED-03',
                'competency' => 'Pedagogik',
                'name' => 'Evaluasi Pembelajaran',
                'description' => 'Kemampuan guru dalam melakukan evaluasi hasil pembelajaran.',
                'weight' => 25,
                'is_active' => true,
            ],

            [
                'code' => 'PED-04',
                'competency' => 'Pedagogik',
                'name' => 'Pengelolaan Peserta Didik',
                'description' => 'Kemampuan guru dalam memahami dan mengelola peserta didik.',
                'weight' => 20,
                'is_active' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | PROFESIONAL
            |--------------------------------------------------------------------------
            */

            [
                'code' => 'PRO-01',
                'competency' => 'Profesional',
                'name' => 'Penguasaan Materi',
                'description' => 'Penguasaan guru terhadap materi pembelajaran.',
                'weight' => 35,
                'is_active' => true,
            ],

            [
                'code' => 'PRO-02',
                'competency' => 'Profesional',
                'name' => 'Pengembangan Profesional',
                'description' => 'Kemampuan guru dalam mengembangkan kompetensi profesional.',
                'weight' => 25,
                'is_active' => true,
            ],

            [
                'code' => 'PRO-03',
                'competency' => 'Profesional',
                'name' => 'Pemanfaatan Teknologi',
                'description' => 'Kemampuan guru dalam memanfaatkan teknologi dalam pembelajaran.',
                'weight' => 20,
                'is_active' => true,
            ],

            [
                'code' => 'PRO-04',
                'competency' => 'Profesional',
                'name' => 'Pengembangan Bahan Ajar',
                'description' => 'Kemampuan guru dalam mengembangkan bahan ajar.',
                'weight' => 20,
                'is_active' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | KEPRIBADIAN
            |--------------------------------------------------------------------------
            */

            [
                'code' => 'KEP-01',
                'competency' => 'Kepribadian',
                'name' => 'Integritas dan Tanggung Jawab',
                'description' => 'Menunjukkan integritas dan tanggung jawab dalam menjalankan tugas.',
                'weight' => 35,
                'is_active' => true,
            ],

            [
                'code' => 'KEP-02',
                'competency' => 'Kepribadian',
                'name' => 'Disiplin',
                'description' => 'Kedisiplinan guru dalam melaksanakan tugas.',
                'weight' => 30,
                'is_active' => true,
            ],

            [
                'code' => 'KEP-03',
                'competency' => 'Kepribadian',
                'name' => 'Keteladanan',
                'description' => 'Kemampuan guru menunjukkan sikap yang dapat menjadi teladan.',
                'weight' => 35,
                'is_active' => true,
            ],

            /*
            |--------------------------------------------------------------------------
            | SOSIAL
            |--------------------------------------------------------------------------
            */

            [
                'code' => 'SOS-01',
                'competency' => 'Sosial',
                'name' => 'Komunikasi',
                'description' => 'Kemampuan guru berkomunikasi dengan peserta didik dan lingkungan sekolah.',
                'weight' => 35,
                'is_active' => true,
            ],

            [
                'code' => 'SOS-02',
                'competency' => 'Sosial',
                'name' => 'Kerja Sama',
                'description' => 'Kemampuan guru bekerja sama dengan warga sekolah.',
                'weight' => 35,
                'is_active' => true,
            ],

            [
                'code' => 'SOS-03',
                'competency' => 'Sosial',
                'name' => 'Hubungan dengan Masyarakat',
                'description' => 'Kemampuan guru membangun hubungan yang baik dengan masyarakat.',
                'weight' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($indicators as $indicator) {
            AssessmentIndicator::updateOrCreate(
                [
                    'code' => $indicator['code'],
                ],
                $indicator
            );
        }
    }
}