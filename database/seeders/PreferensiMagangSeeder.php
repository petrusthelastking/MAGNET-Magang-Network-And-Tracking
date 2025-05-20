<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('preferensi_magang')->insert([
            [
                'mahasiswa_id' => 1,
                'keahlian' => 'Frontend',
                'pekerjaan_impian' => 'Frontend Developer',
                'lokasi_magang' => 'Malang',
                'bidang_industri' => 'Startup Teknologi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2,
                'keahlian' => 'Backend',
                'pekerjaan_impian' => 'Backend Developer',
                'lokasi_magang' => 'Jakarta',
                'bidang_industri' => 'Fintech',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 3,
                'keahlian' => 'Software',
                'pekerjaan_impian' => 'Fullstack Developer',
                'lokasi_magang' => 'Surabaya',
                'bidang_industri' => 'Teknologi Informasi dan Komunikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 4,
                'keahlian' => 'UI/UX Designer',
                'pekerjaan_impian' => 'UI/UX Designer',
                'lokasi_magang' => 'Bandung',
                'bidang_industri' => 'Media dan Kreatif Digital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 5,
                'keahlian' => 'DevOps',
                'pekerjaan_impian' => 'DevOps Engineer',
                'lokasi_magang' => 'Jakarta',
                'bidang_industri' => 'Telekomunikasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 6,
                'keahlian' => 'Data Scientist',
                'pekerjaan_impian' => 'Data Scientist',
                'lokasi_magang' => 'Remote',
                'bidang_industri' => 'Kesehatan Berbasis Teknologi (Healthtech)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 7,
                'keahlian' => 'Mobile',
                'pekerjaan_impian' => 'Mobile Developer',
                'lokasi_magang' => 'Yogyakarta',
                'bidang_industri' => 'E-Commerce',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 8,
                'keahlian' => 'Cyber Security',
                'pekerjaan_impian' => 'Cyber Security Specialist',
                'lokasi_magang' => 'Jakarta',
                'bidang_industri' => 'Pertahanan dan Keamanan Siber',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 9,
                'keahlian' => 'Data Engineer',
                'pekerjaan_impian' => 'Data Engineer',
                'lokasi_magang' => 'Jakarta',
                'bidang_industri' => 'Perbankan dan Keuangan Digital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 10,
                'keahlian' => 'Frontend',
                'pekerjaan_impian' => 'Frontend Developer',
                'lokasi_magang' => 'Semarang',
                'bidang_industri' => 'Pendidikan dan Pelatihan IT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
