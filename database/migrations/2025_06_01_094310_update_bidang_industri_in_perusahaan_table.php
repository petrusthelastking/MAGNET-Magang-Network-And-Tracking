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
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->unsignedBigInteger('bidang_industri_id')->after('nama');
            $table->foreign('bidang_industri_id')->references('id')->on('bidang_industri');

            $table->dropColumn('bidang_industri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perusahaan', function (Blueprint $table) {
            $table->dropForeign(['bidang_industri_id']);
            $table->dropColumn('bidang_industri_id');
            $table->string('bidang_industri')->after('nama');
        });
    }
};
