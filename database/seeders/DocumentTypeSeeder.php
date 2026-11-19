<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $documents = [
            [
                'name' => 'Modul Ajar',
                'description' => 'Dokumen modul atau perangkat pembelajaran yang digunakan guru.',
                'max_score' => 10,
                'is_active' => true,
            ],

            [
                'name' => 'Laporan Pembelajaran',
                'description' => 'Laporan pelaksanaan kegiatan pembelajaran.',
                'max_score' => 10,
                'is_active' => true,
            ],

            [
                'name' => 'Sertifikat Pelatihan',
                'description' => 'Sertifikat kegiatan pelatihan atau pengembangan kompetensi.',
                'max_score' => 10,
                'is_active' => true,
            ],

            [
                'name' => 'Laporan Pengembangan Diri',
                'description' => 'Dokumen kegiatan pengembangan kompetensi atau profesionalisme guru.',
                'max_score' => 10,
                'is_active' => true,
            ],

            [
                'name' => 'Dokumentasi Kegiatan',
                'description' => 'Dokumentasi kegiatan guru yang relevan dengan kinerja.',
                'max_score' => 10,
                'is_active' => true,
            ],

            [
                'name' => 'Berkas Pendukung Lainnya',
                'description' => 'Dokumen tambahan yang dapat mendukung penilaian kinerja guru.',
                'max_score' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($documents as $document) {
            DocumentType::updateOrCreate(
                [
                    'name' => $document['name'],
                ],
                $document
            );
        }
    }
}