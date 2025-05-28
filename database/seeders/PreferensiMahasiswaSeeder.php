<?php

namespace Database\Seeders;

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
                'skil' => 2,
                'bidang_industri' => 3,
                'lokasi' => 4,
                'uang_saku' => 5,
                'open_remote' => 1
            ],
            [
                'mahasiswa_id' => 2,
                'skil' => 7,
                'bidang_industri' => 8,
                'lokasi' => 9,
                'uang_saku' => 10,
                'open_remote' => 6
            ],
        ]);
    }
}
