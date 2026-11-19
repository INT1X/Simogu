<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan hubungan dokumen dengan periode penilaian.
     */
    public function up(): void
    {
        Schema::table('teacher_documents', function (Blueprint $table) {
            // Cek dulu apakah kolom assessment_period_id sudah ada
            if (!Schema::hasColumn('teacher_documents', 'assessment_period_id')) {
                $table->foreignId('assessment_period_id')
                    ->nullable()
                    ->constrained('assessment_periods')
                    ->nullOnDelete();
            }
        });
    }

    /**
     * Menghapus hubungan periode jika migrasi dibatalkan.
     */
    public function down(): void
    {
        Schema::table('teacher_documents', function (Blueprint $table) {
            if (Schema::hasColumn('teacher_documents', 'assessment_period_id')) {
                $table->dropConstrainedForeignId('assessment_period_id');
            }
        });
    }
};