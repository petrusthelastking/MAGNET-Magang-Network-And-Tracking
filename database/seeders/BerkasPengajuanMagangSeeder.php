<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BerkasPengajuanMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('berkas_pengajuan_magang')->insert([
            [
                'mahasiswa_id' => 1,
                'cv' => 'cv_andi_pratama.pdf',
                'transkrip_nilai' => 'transkrip_andi_pratama.pdf',
                'portfolio' => 'portfolio_andi_pratama.pdf'
            ],
            [
                'mahasiswa_id' => 4,
                'cv' => 'cv_maya_sari.pdf',
                'transkrip_nilai' => 'transkrip_maya_sari.pdf',
                'portfolio' => 'portfolio_maya_sari.pdf'
            ],
            [
                'mahasiswa_id' => 6,
                'cv' => 'cv_fitri_handayani.pdf',
                'transkrip_nilai' => 'transkrip_fitri_handayani.pdf',
                'portfolio' => 'portfolio_fitri_handayani.pdf'
            ],
            [
                'mahasiswa_id' => 8,
                'cv' => 'cv_ratna_wulandari.pdf',
                'transkrip_nilai' => 'transkrip_ratna_wulandari.pdf',
                'portfolio' => 'portfolio_ratna_wulandari.pdf'
            ],
            [
                'mahasiswa_id' => 10,
                'cv' => 'cv_lestari_putri.pdf',
                'transkrip_nilai' => 'transkrip_lestari_putri.pdf',
                'portfolio' => 'portfolio_lestari_putri.pdf'
            ],
        ]);
    }
}

