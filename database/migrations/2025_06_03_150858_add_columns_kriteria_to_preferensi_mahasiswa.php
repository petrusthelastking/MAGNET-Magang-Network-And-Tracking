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
        Schema::table('preferensi_mahasiswa', function (Blueprint $table) {
            $table->foreignId('kriteria_pekerjaan_id')->constrained('kriteria_pekerjaan')->onDelete('cascade');
            $table->foreignId('kriteria_bidang_industri_id')->constrained('kriteria_bidang_industri')->onDelete('cascade');
            $table->foreignId('kriteria_lokasi_magang_id')->constrained('kriteria_lokasi_magang')->onDelete('cascade');
            $table->foreignId('kriteria_reputasi_perusahaan_id')->constrained('kriteria_reputasi_perusahaan')->onDelete('cascade');
            $table->foreignId('kriteria_jenis_magang_id')->constrained('kriteria_jenis_magang')->onDelete('cascade');
            $table->foreignId('kriteria_open_remote_id')->constrained('kriteria_open_remote')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('preferensi_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['kriteria_pekerjaan_id']);
            $table->dropColumn('kriteria_pekerjaan_id');

            $table->dropForeign(['kriteria_bidang_industri_id']);
            $table->dropColumn('kriteria_bidang_industri_id');

            $table->dropForeign(['kriteria_lokasi_magang_id']);
            $table->dropColumn('kriteria_lokasi_magang_id');

            $table->dropForeign(['kriteria_reputasi_perusahaan_id']);
            $table->dropColumn('kriteria_reputasi_perusahaan_id');

            $table->dropForeign(['kriteria_jenis_magang_id']);
            $table->dropColumn('kriteria_jenis_magang_id');

            $table->dropForeign(['kriteria_open_remote_id']);
            $table->dropColumn('kriteria_open_remote_id');
        });
    }
};
