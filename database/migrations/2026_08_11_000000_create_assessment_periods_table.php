
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_periods', function (Blueprint $table) {
            $table->id();

            // Tahun ajaran, contoh: 2026/2027
            $table->string('academic_year', 9);

            // Semester ganjil atau genap
            $table->enum('semester', ['ganjil', 'genap']);

            // Jadwal periode penilaian
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // draft = belum dibuka, active = sedang dibuka,
            // closed = sudah ditutup
            $table->enum('status', ['draft', 'active', 'closed'])
                ->default('draft');

            $table->timestamps();

            // Satu semester hanya boleh dibuat sekali
            $table->unique(
                ['academic_year', 'semester'],
                'assessment_period_year_semester_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_periods');
    }
};
