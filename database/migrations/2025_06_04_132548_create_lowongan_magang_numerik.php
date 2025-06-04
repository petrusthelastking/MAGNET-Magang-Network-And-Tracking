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
        Schema::create('lowongan_magang_numerik', function (Blueprint $table) {
            $table->unsignedBigInteger('lowongan_magang_id')->primary();
            $table->integer('lokasi_num');
            $table->integer('pekerjaan_num');
            $table->integer('jenis_magang_num');
            $table->integer('open_remote_num');
            $table->integer('bidang_industri_num');

            $table->foreign('lowongan_magang_id')->references('id')->on('lowongan_magang')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_magang_numerik');
    }
};
