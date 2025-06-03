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
        Schema::create('kriteria_jenis_magang', function (Blueprint $table) {
            $table->id();
            $table->enum('jenis_magang', ['berbayar', 'tidak berbayar']);
            $table->integer('rank');
            $table->float('bobot');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_jenis_magang');
    }
};
