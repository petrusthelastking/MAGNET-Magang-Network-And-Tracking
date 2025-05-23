<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('perusahaan')->insert([
            [
                'nama' => 'PT Bank Central Asia Tbk',
                'bidang_industri' => 'Perbankan',
                'lokasi' => 'Jakarta',
                'kategori' => 'mitra',
                'rating' => 4.5
            ],
            [
                'nama' => 'PT Telekomunikasi Indonesia Tbk',
                'bidang_industri' => 'Telekomunikasi',
                'lokasi' => 'Bandung',
                'kategori' => 'mitra',
                'rating' => 4.3
            ],
            [
                'nama' => 'PT Gojek Indonesia',
                'bidang_industri' => 'Teknologi',
                'lokasi' => 'Jakarta',
                'kategori' => 'mitra',
                'rating' => 4.7
            ],
            [
                'nama' => 'PT Shopee International Indonesia',
                'bidang_industri' => 'E-Commerce',
                'lokasi' => 'Jakarta',
                'kategori' => 'mitra',
                'rating' => 4.4
            ],
            [
                'nama' => 'RSUD Dr. Soetomo',
                'bidang_industri' => 'Kesehatan',
                'lokasi' => 'Surabaya',
                'kategori' => 'mitra',
                'rating' => 4.2
            ],
            [
                'nama' => 'PT Pertamina (Persero)',
                'bidang_industri' => 'Energi',
                'lokasi' => 'Jakarta',
                'kategori' => 'mitra',
                'rating' => 4.6
            ],
            [
                'nama' => 'PT Astra International Tbk',
                'bidang_industri' => 'Manufaktur',
                'lokasi' => 'Jakarta',
                'kategori' => 'mitra',
                'rating' => 4.5
            ],
            [
                'nama' => 'Universitas Indonesia',
                'bidang_industri' => 'Pendidikan',
                'lokasi' => 'Depok',
                'kategori' => 'mitra',
                'rating' => 4.8
            ],
            [
                'nama' => 'PT Indofood Sukses Makmur Tbk',
                'bidang_industri' => 'Manufaktur',
                'lokasi' => 'Jakarta',
                'kategori' => 'non_mitra',
                'rating' => 4.1
            ],
            [
                'nama' => 'PT Garuda Indonesia (Persero)',
                'bidang_industri' => 'Transportasi',
                'lokasi' => 'Jakarta',
                'kategori' => 'mitra',
                'rating' => 4.0
            ],
        ]);
    }
}
