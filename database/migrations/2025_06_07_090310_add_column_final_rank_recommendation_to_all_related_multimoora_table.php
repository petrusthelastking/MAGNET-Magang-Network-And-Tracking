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
        Schema::table('ratio_system', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['lowongan_magang_id']);

            $table->dropColumn(['mahasiswa_id', 'lowongan_magang_id']);

            $table->foreignId('final_rank_recommendation_id')
                ->nullable()
                ->after('id')
                ->constrained('final_rank_recommendation')
                ->onDelete('cascade');
        });

        Schema::table('reference_point', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['lowongan_magang_id']);

            $table->dropColumn(['mahasiswa_id', 'lowongan_magang_id']);

            $table->foreignId('final_rank_recommendation_id')
                ->nullable()
                ->after('id')
                ->constrained('final_rank_recommendation')
                ->onDelete('cascade');
        });

        Schema::table('full_multiplicative_form', function (Blueprint $table) {
            $table->dropForeign(['mahasiswa_id']);
            $table->dropForeign(['lowongan_magang_id']);

            $table->dropColumn(['mahasiswa_id', 'lowongan_magang_id']);

            $table->foreignId('final_rank_recommendation_id')
                ->nullable()
                ->after('id')
                ->constrained('final_rank_recommendation')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ratio_system', function (Blueprint $table) {
            $table->dropForeign(['final_rank_recommendation_id']);
            $table->dropColumn('final_rank_recommendation_id');

            $table->foreignId('mahasiswa_id')
                ->after('id')
                ->constrained('mahasiswa')
                ->onDelete('cascade');

            $table->foreignId('lowongan_magang_id')
                ->after('mahasiswa_id')
                ->constrained('lowongan_magang')
                ->onDelete('cascade');
        });

        Schema::table('reference_point', function (Blueprint $table) {
            $table->dropForeign(['final_rank_recommendation_id']);
            $table->dropColumn('final_rank_recommendation_id');

            $table->foreignId('mahasiswa_id')
                ->after('id')
                ->constrained('mahasiswa')
                ->onDelete('cascade');

            $table->foreignId('lowongan_magang_id')
                ->after('mahasiswa_id')
                ->constrained('lowongan_magang')
                ->onDelete('cascade');
        });

        Schema::table('full_multiplicative_form', function (Blueprint $table) {
            $table->dropForeign(['final_rank_recommendation_id']);
            $table->dropColumn('final_rank_recommendation_id');

            $table->foreignId('mahasiswa_id')
                ->after('id')
                ->constrained('mahasiswa')
                ->onDelete('cascade');

            $table->foreignId('lowongan_magang_id')
                ->after('mahasiswa_id')
                ->constrained('lowongan_magang')
                ->onDelete('cascade');
        });
    }
};
