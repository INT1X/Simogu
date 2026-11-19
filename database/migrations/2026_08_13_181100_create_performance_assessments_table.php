<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('performance_assessments', function (Blueprint $table) {
            $table->id();
            
            // Relasi utama sesuai Model
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('supervisor_id')->constrained('supervisors')->cascadeOnDelete();
            $table->foreignId('assessment_period_id')->nullable()->constrained('assessment_periods')->cascadeOnDelete();
            
            // Atribut tanggal & nilai indikator penilaian skripsi
            $table->date('assessment_date')->nullable();
            $table->decimal('avg_pedagogik', 5, 2)->default(0);
            $table->decimal('avg_kepribadian', 5, 2)->default(0);
            $table->decimal('avg_sosial', 5, 2)->default(0);
            $table->decimal('avg_profesional', 5, 2)->default(0);
            $table->decimal('final_score', 5, 2)->default(0);
            $table->string('final_classification')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_assessments');
    }
};