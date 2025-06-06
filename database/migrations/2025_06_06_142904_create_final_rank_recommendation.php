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
        Schema::create('final_rank_recommendation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ratio_system_id')->constrained('ratio_system')->onDelete('cascade');
            $table->foreignId('reference_point_id')->constrained('reference_point')->onDelete('cascade');
            $table->foreignId('fmf_id')->constrained('full_multiplicative_form')->onDelete('cascade');
            $table->float('avg_rank');
            $table->integer('rank');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_rank_recommendation');
    }
};
