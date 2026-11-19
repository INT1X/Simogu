<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. BUAT TABEL UTAMA JIKA BELUM ADA (Mengganti file yang hilang tadi)
        if (!Schema::hasTable('performance_assessments')) {
            Schema::create('performance_assessments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
                $table->foreignId('supervisor_id')->constrained()->onDelete('cascade');
                $table->date('assessment_date');
                $table->decimal('avg_pedagogik', 5, 2)->nullable();
                $table->decimal('avg_kepribadian', 5, 2)->nullable();
                $table->decimal('avg_sosial', 5, 2)->nullable();
                $table->decimal('avg_profesional', 5, 2)->nullable();
                $table->decimal('final_score', 5, 2)->nullable();
                $table->string('final_classification', 100)->nullable();
                $table->timestamps();
            });
        }

        // 2. BUAT TABEL DETAIL (Kode asli milik Anda)
        Schema::create('assessment_details', function (Blueprint $table) {
            $table->id();

            // Relasi ke penilaian utama
            $table->foreignId('performance_assessment_id')
                ->constrained('performance_assessments')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Kompetensi Pedagogik (7 indikator)
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('ped_1');
            $table->unsignedTinyInteger('ped_2');
            $table->unsignedTinyInteger('ped_3');
            $table->unsignedTinyInteger('ped_4');
            $table->unsignedTinyInteger('ped_5');
            $table->unsignedTinyInteger('ped_6');
            $table->unsignedTinyInteger('ped_7');

            /*
            |--------------------------------------------------------------------------
            | Kompetensi Kepribadian (3 indikator)
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('kpb_1');
            $table->unsignedTinyInteger('kpb_2');
            $table->unsignedTinyInteger('kpb_3');

            /*
            |--------------------------------------------------------------------------
            | Kompetensi Sosial (2 indikator)
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('sos_1');
            $table->unsignedTinyInteger('sos_2');

            /*
            |--------------------------------------------------------------------------
            | Kompetensi Profesional (2 indikator)
            |--------------------------------------------------------------------------
            */
            $table->unsignedTinyInteger('prf_1');
            $table->unsignedTinyInteger('prf_2');

            /*
            |--------------------------------------------------------------------------
            | Rata-rata Kompetensi
            |--------------------------------------------------------------------------
            */
            $table->decimal('avg_pedagogik', 4, 2)->nullable();
            $table->decimal('avg_kepribadian', 4, 2)->nullable();
            $table->decimal('avg_sosial', 4, 2)->nullable();
            $table->decimal('avg_profesional', 4, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_details');
        Schema::dropIfExists('performance_assessments');
    }
};
