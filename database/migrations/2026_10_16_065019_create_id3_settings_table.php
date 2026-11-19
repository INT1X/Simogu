
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('id3_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('batas_cukup', 5, 2)->default(30);
            $table->decimal('batas_baik', 5, 2)->default(60);
            $table->decimal('batas_sangat_baik', 5, 2)->default(80);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('id3_settings');
    }
};
