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
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->renameColumn('lokasi', 'lokasi_magang_id');
        });

        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->unsignedBigInteger('lokasi_magang_id')->change();
            $table->foreign('lokasi_magang_id')->references('id')->on('lokasi_magang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->dropForeign(['lokasi_magang_id']);
        });

        Schema::table('lowongan_magang', function (Blueprint $table) {
            $table->renameColumn('lokasi_magang_id', 'lokasi');
            $table->string('lokasi', 100)->change();
        });
    }
};
