<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('preferensi_mahasiswa')->insert([
            [
                'mahasiswa_id' => 1,
                'bidang_pekerjaan' => 1,
                'Lokasi' => 6,
                'reputasi' => 10,
                'uang_saku' => 12,
                'open_remote' => 14
            ],
            [
                'mahasiswa_id' => 2,
                'bidang_pekerjaan' => 1,
                'Lokasi' => 9,
                'reputasi' => 10,
                'uang_saku' => 13,
                'open_remote' => 14
            ],
            [
                'mahasiswa_id' => 3,
                'bidang_pekerjaan' => 2,
                'Lokasi' => 6,
                'reputasi' => 10,
                'uang_saku' => 12,
                'open_remote' => 15
            ],
            [
                'mahasiswa_id' => 4,
                'bidang_pekerjaan' => 2,
                'Lokasi' => 6,
                'reputasi' => 11,
                'uang_saku' => 12,
                'open_remote' => 15
            ],
            [
                'mahasiswa_id' => 5,
                'bidang_pekerjaan' => 1,
                'Lokasi' => 7,
                'reputasi' => 10,
                'uang_saku' => 13,
                'open_remote' => 14
            ],
            [
                'mahasiswa_id' => 6,
                'bidang_pekerjaan' => 3,
                'Lokasi' => 8,
                'reputasi' => 11,
                'uang_saku' => 13,
                'open_remote' => 15
            ],
            [
                'mahasiswa_id' => 7,
                'bidang_pekerjaan' => 5,
                'Lokasi' => 8,
                'reputasi' => 10,
                'uang_saku' => 13,
                'open_remote' => 15
            ],
            [
                'mahasiswa_id' => 8,
                'bidang_pekerjaan' => 3,
                'Lokasi' => 8,
                'reputasi' => 10,
                'uang_saku' => 12,
                'open_remote' => 15
            ],
            [
                'mahasiswa_id' => 9,
                'bidang_pekerjaan' => 1,
                'Lokasi' => 6,
                'reputasi' => 10,
                'uang_saku' => 12,
                'open_remote' => 14
            ],
            [
                'mahasiswa_id' => 10,
                'bidang_pekerjaan' => 2,
                'Lokasi' => 8,
                'reputasi' => 11,
                'uang_saku' => 13,
                'open_remote' => 15
            ],
        ]);
    }
}
