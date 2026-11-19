
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('id3_labels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assessment_id')
                ->unique()
                ->constrained('assessments')
                ->cascadeOnDelete();

            $table->string('label', 50);

            $table->foreignId('labeled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('label');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('id3_labels');
    }
};
