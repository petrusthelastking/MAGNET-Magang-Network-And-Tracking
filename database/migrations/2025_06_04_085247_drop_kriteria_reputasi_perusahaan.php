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
        Schema::table('preferensi_mahasiswa', function (Blueprint $table) {
            $table->dropForeign(['kriteria_reputasi_perusahaan_id']);
            $table->dropColumn('kriteria_reputasi_perusahaan_id');
        });

        Schema::dropIfExists('kriteria_reputasi_perusahaan');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('kriteria_reputasi_perusahaan', function (Blueprint $table) {
            $table->id();
            $table->enum('reputasi_perusahaan', ['<1', '1<= x <2', '2<= x <3', '3<= x <4', '4<= x <5']);
            $table->integer('rank');
            $table->decimal('bobot', 30, 15);

            $table->timestamps();
        });

        Schema::create('preferensi_mahasiswa', function (Blueprint $table) {
            $table->foreignId('kriteria_reputasi_perusahaan_id')->constrained('kriteria_reputasi_perusahaan')->onDelete('cascade');
        });
    }
};
