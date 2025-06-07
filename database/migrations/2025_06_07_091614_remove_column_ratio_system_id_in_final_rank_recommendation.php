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
            $table->dropForeign(['ratio_system_id']);
            $table->dropColumn(['ratio_system_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('final_rank_recommendation', function (Blueprint $table) {
            $table->foreignId('ratio_system_id')->constrained('ratio_system')->onDelete('cascade');
        });
    }
};
