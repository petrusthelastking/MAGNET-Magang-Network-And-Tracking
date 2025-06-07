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
        Schema::table('final_rank_recommendation', function (Blueprint $table) {
            $table->foreignId('mahasiswa_id')
                ->after('id')
                ->constrained('mahasiswa')
                ->onDelete('cascade');

            $table->foreignId('lowongan_magang_id')
                ->after('id')
                ->constrained('lowongan_magang')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_rank_recommendation', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['lowongan_magang_id']);

            $table->dropColumn(['mahasiswa_id', 'lowongan_magang_id']);
        });
    }
};
