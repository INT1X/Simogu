<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_indicators', function (Blueprint $table) {

            $table->id();

            $table->string('code', 20)->unique();

            $table->string('competency', 50);

            $table->string('name');

            $table->text('description')->nullable();

            $table->decimal('weight', 5, 2)->default(0);

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_indicators');
    }
};