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
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('provinsi', 100);
            $table->enum('bidang_industri', ['Perbankan', 'Kesehatan', 'Pendidikan', 'E-Commerce', 'Telekomunikasi', 'Transportasi', 'Pemerintahan', 'Manufaktur', 'Energi', 'Media', 'Teknologi', 'Agrikultur', 'Pariwisata', 'Keamanan']);
            $table->string('no_telp', 15)->nullable();
            $table->string('email')->nullable();
            $table->text('deskripsi')->nullable();
            $table->year('tahun_berdiri');
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perusahaan');
    }
};
