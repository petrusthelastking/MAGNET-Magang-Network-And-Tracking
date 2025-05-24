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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->string('password');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->integer('umur');
            $table->integer('angkatan');
            $table->string('jurusan');
            $table->string('program_studi');
            $table->enum('status_magang', ['belum magang', 'sedang magang', 'selesai magang'])->default('belum magang');
            $table->text('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
