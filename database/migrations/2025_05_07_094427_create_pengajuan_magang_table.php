<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa_profiles');
            $table->foreignId('lowongan_id')->nullable()->constrained('lowongan_magang');
            $table->foreignId('dosen_id')->nullable()->constrained('dosen_profiles');
            $table->string('cv')->nullable();
            $table->string('transkrip_nilai')->nullable();
            $table->string('portofolio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_magang');
    }
};
