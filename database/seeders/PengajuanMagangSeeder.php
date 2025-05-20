<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengajuan_magang')->insert([
            [
                'mahasiswa_id' => 1, // Ahmad Fadli
                'lowongan_id' => 1, // Web Developer Internship
                'dosen_id' => 1, // Dr. Agus Wijaya
                'cv' => 'surat/ahmad_fadli_surat_magang.pdf',
                'transkrip_nilai' => 'surat/ahmad_fadli_surat_transkrip_nilai.pdf',
                'portofolio' => 'surat/ahmad_fadli_surat_portofolio.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2, // Rina Fitriani
                'lowongan_id' => 6, // Digital Marketing Internship
                'dosen_id' => 2, // Prof. Siti Rahayu
                'cv' => 'surat/rina_fitriani_surat_magang.pdf',
                'transkrip_nilai' => 'surat/rina_fitriani_surat_transkrip_nilai.pdf',
                'proposal' => 'surat/rina_fitriani_surat_proposal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 3, // Dimas Pratama
                'lowongan_id' => 5, // Mobile App Developer Internship
                'dosen_id' => 3, // Dr. Bambang Hermawan
                'cv' => 'surat/dimas_pratama_surat_magang.pdf',
                'transkrip_nilai' => 'surat/dimas_pratama_surat_transkrip_nilai.pdf',
                'proposal' => 'surat/dimas_pratama_surat_proposal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 4, // Anisa Rahma
                'lowongan_id' => 4, // Data Science Internship
                'dosen_id' => 4, // Dr. Dewi Sulistyowati
                'cv' => 'surat/anisa_rahma_surat_magang.pdf',
                'transkrip_nilai' => 'surat/anisa_rahma_surat_transkrip_nilai.pdf',
                'proposal' => 'surat/anisa_rahma_surat_proposal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 5, // Fajar Nugroho
                'lowongan_id' => 1, // Web Developer Internship
                'dosen_id' => 1, // Dr. Agus Wijaya
                'cv' => 'surat/fajar_nugroho_surat_magang.pdf',
                'transkrip_nilai' => 'surat/fajar_nugroho_surat_transkrip_nilai.pdf',
                'portofolio' => 'surat/fajar_nugroho_surat_portofolio.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 6, // Ratna Dewi
                'lowongan_id' => 2, // UI/UX Designer Internship
                'dosen_id' => 3, // Dr. Bambang Hermawan
                'cv' => 'surat/ratna_dewi_surat_magang.pdf',
                'transkrip_nilai' => 'surat/ratna_dewi_surat_transkrip_nilai.pdf',
                'proposal' => 'surat/ratna_dewi_surat_proposal.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
