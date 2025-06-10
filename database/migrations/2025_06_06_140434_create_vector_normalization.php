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
        Schema::create('vector_normalization', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa')->onDelete('cascade');
            $table->foreignId('lowongan_magang_id')->constrained('lowongan_magang')->onDelete('cascade');
            $table->decimal('pekerjaan', 30, 15);
            $table->decimal('open_remote', 30, 15);
            $table->decimal('jenis_magang', 30, 15);
            $table->decimal('bidang_industri', 30, 15);
            $table->decimal('lokasi_magang', 30, 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vector_normalization');
    }
};
