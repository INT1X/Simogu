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
        // Diubah menjadi assessment_component_details agar tidak bentrok
        Schema::create('assessment_component_details', function (Blueprint $table) {

            $table->id();

            $table->foreignId('assessment_id')
                ->constrained('assessments')
                ->cascadeOnDelete();

            $table->foreignId('indicator_id')
                ->constrained('assessment_indicators')
                ->cascadeOnDelete();

            $table->decimal('score', 5, 2)
                ->default(0);

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Mencegah satu indikator dinilai dua kali
            |--------------------------------------------------------------------------
            */
            $table->unique([
                'assessment_id',
                'indicator_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_component_details');
    }
};
