<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_verifications', function (Blueprint $table) {

            $table->id();

            $table->foreignId('teacher_document_id')
                ->constrained('teacher_documents')
                ->cascadeOnDelete();

            $table->foreignId('supervisor_id')
                ->constrained('supervisors')
                ->cascadeOnDelete();

            /*
             * verified / rejected
             */

            $table->string('status');

            /*
             * Nilai dokumen 1 - 5
             */

            $table->decimal('score', 5, 2)->nullable();

            $table->text('notes')->nullable();

            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_verifications');
    }
};