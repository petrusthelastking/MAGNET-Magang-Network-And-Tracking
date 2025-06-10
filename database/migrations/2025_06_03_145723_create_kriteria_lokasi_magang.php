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
        Schema::create('kriteria_lokasi_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_magang_id')->constrained('lokasi_magang')->onDelete('cascade');
            $table->integer('rank');
            $table->decimal('bobot', 30, 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_lokasi_magang');
    }
};
