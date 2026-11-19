<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('performance_assessments', function (Blueprint $table) {
            // Cek apakah kolom assessment_period_id belum ada sebelum menambahkannya
            if (!Schema::hasColumn('performance_assessments', 'assessment_period_id')) {
                $table->foreignId('assessment_period_id')
                    ->nullable()
                    ->constrained('assessment_periods')
                    ->nullOnDelete();

                $table->index(
                    ['teacher_id', 'assessment_period_id'],
                    'performance_assessments_teacher_period_index'
                );
            }
        });
    }

    public function down(): void
    {
        Schema::table('performance_assessments', function (Blueprint $table) {
            if (Schema::hasColumn('performance_assessments', 'assessment_period_id')) {
                $table->dropForeign(['assessment_period_id']);
                $table->dropIndex('performance_assessments_teacher_period_index');
                $table->dropColumn('assessment_period_id');
            }
        });
    }
};