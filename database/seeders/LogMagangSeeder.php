<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('log_magang')->insert([
            [
                'kontrak_magang_id' => 1,
                'kegiatan' => 'Orientasi dan pengenalan sistem IT perusahaan',
                'tanggal' => '2024-02-01',
                'jam_masuk' => '08:00',
                'jam_keluar' => '17:00'
            ],
            [
                'kontrak_magang_id' => 1,
                'kegiatan' => 'Troubleshooting komputer karyawan divisi finance',
                'tanggal' => '2024-02-02',
                'jam_masuk' => '08:15',
                'jam_keluar' => '17:00'
            ],
            [
                'kontrak_magang_id' => 2,
                'kegiatan' => 'Mempelajari konfigurasi router dan switch',
                'tanggal' => '2024-03-01',
                'jam_masuk' => '08:00',
                'jam_keluar' => '17:00'
            ],
            [
                'kontrak_magang_id' => 2,
                'kegiatan' => 'Monitoring traffic network dan analisis performance',
                'tanggal' => '2024-03-02',
                'jam_masuk' => '08:00',
                'jam_keluar' => '17:30'
            ],
            [
                'kontrak_magang_id' => 3,
                'kegiatan' => 'Development fitur tracking order real-time',
                'tanggal' => '2024-01-15',
                'jam_masuk' => '09:00',
                'jam_keluar' => '18:00'
            ],
            [
                'kontrak_magang_id' => 4,
                'kegiatan' => 'Analisis data penjualan kuartal IV 2023',
                'tanggal' => '2023-09-01',
                'jam_masuk' => '08:30',
                'jam_keluar' => '17:30'
            ],
            [
                'kontrak_magang_id' => 5,
                'kegiatan' => 'Training K3 dan safety procedure di pabrik',
                'tanggal' => '2023-08-01',
                'jam_masuk' => '07:00',
                'jam_keluar' => '16:00'
            ],
        ]);
    }
}
