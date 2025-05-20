<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preferensi_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswa_profiles');
            $table->enum('keahlian', ['Frontend', 'Backend', 'Software', 'DevOps', 'Data Scientist', 'Data Engineer', 'UI/UX Designer', 'Cyber Security', 'Mobile']);
            $table->enum('pekerjaan_impian', [
                'Frontend Developer',
                'Backend Developer',
                'Fullstack Developer',
                'Mobile Developer',
                'DevOps Engineer',
                'Data Scientist',
                'Data Engineer',
                'UI/UX Designer',
                'Cyber Security Specialist',
                'Game Developer',
                'AI Engineer',
                'Software Architect',
                'Product Manager',
                'QA Engineer',
                'System Analyst'
            ]);
            $table->enum('lokasi_magang', [
                'Malang',
                'Surabaya',
                'Jakarta',
                'Bandung',
                'Yogyakarta',
                'Semarang',
                'Denpasar',
                'Makassar',
                'Balikpapan',
                'Medan',
                'Remote'
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preferensi_keahlian');
    }
};
