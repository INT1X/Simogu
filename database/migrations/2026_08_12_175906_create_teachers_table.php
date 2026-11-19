<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('school_id')
                ->constrained('schools')
                ->cascadeOnDelete();

            // Foto profil guru
            $table->string('photo')->nullable();

            $table->string('name');
            $table->string('nip')->nullable()->unique();
            $table->string('nik')->nullable()->unique();
            $table->string('gender')->nullable();
            $table->string('subject')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('employment_status')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};