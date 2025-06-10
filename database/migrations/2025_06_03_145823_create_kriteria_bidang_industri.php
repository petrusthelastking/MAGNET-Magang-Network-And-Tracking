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
        Schema::create('kriteria_bidang_industri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_industri_id')->constrained('bidang_industri')->onDelete('cascade');
            $table->integer('rank');
            $table->decimal('bobot', 30, 15);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_bidang_industri');
    }
};
