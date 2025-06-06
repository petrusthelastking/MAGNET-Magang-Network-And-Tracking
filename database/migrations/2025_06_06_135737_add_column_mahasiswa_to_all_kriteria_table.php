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
        Schema::table('kriteria_pekerjaan', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->after('pekerjaan_id')->constrained('mahasiswa')->onDelete('cascade');
        });

        Schema::table('kriteria_bidang_industri', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->after('bidang_industri_id')->constrained('mahasiswa')->onDelete('cascade');
        });

        Schema::table('kriteria_jenis_magang', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->after('jenis_magang')->constrained('mahasiswa')->onDelete('cascade');
        });

        Schema::table('kriteria_lokasi_magang', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->after('lokasi_magang_id')->constrained('mahasiswa')->onDelete('cascade');
        });

        Schema::table('kriteria_open_remote', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')->after('open_remote')->constrained('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kriteria_pekerjaan', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });

        Schema::table('kriteria_bidang_industri', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });

        Schema::table('kriteria_jenis_magang', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });

        Schema::table('kriteria_lokasi_magang', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });

        Schema::table('kriteria_open_remote', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropColumn('mahasiswa_id');
        });
    }
};
