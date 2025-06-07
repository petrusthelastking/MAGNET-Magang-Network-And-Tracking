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
            $table->foreignId('ratio_system_id')
                ->after('mahasiswa_id')
                ->constrained('ratio_system')
                ->onDelete('cascade');

            $table->foreignId('reference_point_id')
                ->after('ratio_system_id')
                ->constrained('reference_point')
                ->onDelete('cascade');

            $table->foreignId('fmf_id')
                ->after('reference_point_id')
                ->constrained('full_multiplicative_form')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_rank_recommendation', function (Blueprint $table) {
            $table->dropForeign(['fmf_id']);
            $table->dropColumn('fmf_id');

            $table->dropForeign(['reference_point_id']);
            $table->dropColumn('reference_point_id');

            $table->dropForeign(['ratio_system_id']);
            $table->dropColumn('ratio_system_id');
        });
    }
};
