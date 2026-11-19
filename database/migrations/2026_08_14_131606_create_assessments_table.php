<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('teacher_id')
                ->constrained('teachers')
                ->cascadeOnDelete();

            $table->foreignId('supervisor_id')
                ->constrained('supervisors')
                ->cascadeOnDelete();

            $table->date('assessment_date');

            /*
             * Rata-rata masing-masing kompetensi
             */

            $table->decimal('pedagogik_score', 5, 2)->nullable();

            $table->decimal('kepribadian_score', 5, 2)->nullable();

            $table->decimal('sosial_score', 5, 2)->nullable();

            $table->decimal('profesional_score', 5, 2)->nullable();

            /*
             * Nilai dokumen
             */

            $table->decimal('document_score', 5, 2)
                ->default(0);

            /*
             * Skor akhir sebelum Decision Tree
             */

            $table->decimal('final_score', 5, 2)->nullable();

            /*
             * Hasil Decision Tree
             */

            $table->string('classification')->nullable();

            /*
             * Contoh:
             * pending
             * completed
             */

            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};