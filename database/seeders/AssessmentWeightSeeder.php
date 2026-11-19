<?php

namespace Database\Seeders;

use App\Models\AssessmentWeight;
use Illuminate\Database\Seeder;

class AssessmentWeightSeeder extends Seeder
{
    public function run(): void
    {
        $weights = [
            [
                'competency' => 'Pedagogik',
                'weight' => 30,
                'is_active' => true,
            ],
            [
                'competency' => 'Profesional',
                'weight' => 30,
                'is_active' => true,
            ],
            [
                'competency' => 'Kepribadian',
                'weight' => 20,
                'is_active' => true,
            ],
            [
                'competency' => 'Sosial',
                'weight' => 20,
                'is_active' => true,
            ],
        ];

        foreach ($weights as $weight) {
            AssessmentWeight::updateOrCreate(
                [
                    'competency' => $weight['competency'],
                ],
                $weight
            );
        }
    }
}