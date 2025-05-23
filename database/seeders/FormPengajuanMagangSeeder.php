<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormPengajuanMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('form_pengajuan_magang')->insert([
            [
                'pengajuan_id' => 1,
                'status' => 'menunggu',
                'keterangan' => 'Sedang dalam proses review oleh HRD perusahaan'
            ],
            [
                'pengajuan_id' => 2,
                'status' => 'diterima',
                'keterangan' => 'Selamat! Anda diterima untuk program magang. Silahkan datang pada tanggal yang telah ditentukan.'
            ],
            [
                'pengajuan_id' => 3,
                'status' => 'menunggu',
                'keterangan' => 'Dokumen lengkap, menunggu jadwal interview'
            ],
            [
                'pengajuan_id' => 4,
                'status' => 'ditolak',
                'keterangan' => 'Maaf, saat ini kuota untuk program magang sudah penuh. Silahkan coba di periode selanjutnya.'
            ],
            [
                'pengajuan_id' => 5,
                'status' => 'diterima',
                'keterangan' => 'Diterima dengan syarat melengkapi sertifikat kesehatan dalam 1 minggu'
            ],
        ]);
    }
}
