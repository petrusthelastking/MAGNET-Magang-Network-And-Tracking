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
            $table->dropForeign(['reference_point_id']);
            $table->dropColumn(['reference_point_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_rank_recommendation', function (Blueprint $table) {
            $table->foreignId('reference_point_id')->constrained('reference_point')->onDelete('cascade');
        });
    }
};
