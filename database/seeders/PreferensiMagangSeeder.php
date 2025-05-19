<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PreferensiMagangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('preferensi_magang')->insert([
            [
                'mahasiswa_id' => 1, // Andi Kurniawan
                'keahlian' => 'Frontend',
                'pekerjaan_impian' => 'Frontend Developer',
                'lokasi_magang' => 'Malang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 2, // Bella Safitri
                'keahlian' => 'Backend',
                'pekerjaan_impian' => 'Backend Developer',
                'lokasi_magang' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 3, // Candra Wijaya
                'keahlian' => 'Software',
                'pekerjaan_impian' => 'Fullstack Developer',
                'lokasi_magang' => 'Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 4, // Diana Puspitasari
                'keahlian' => 'UI/UX Designer',
                'pekerjaan_impian' => 'UI/UX Designer',
                'lokasi_magang' => 'Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 5, // Eko Setiawan
                'keahlian' => 'DevOps',
                'pekerjaan_impian' => 'DevOps Engineer',
                'lokasi_magang' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 6, // Fira Ramadhani
                'keahlian' => 'Data Scientist',
                'pekerjaan_impian' => 'Data Scientist',
                'lokasi_magang' => 'Remote',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 7, // Gilang Pratama
                'keahlian' => 'Mobile',
                'pekerjaan_impian' => 'Mobile Developer',
                'lokasi_magang' => 'Yogyakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 8, // Hana Permata
                'keahlian' => 'Cyber Security',
                'pekerjaan_impian' => 'Cyber Security Specialist',
                'lokasi_magang' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 9, // Indra Saputra
                'keahlian' => 'Data Engineer',
                'pekerjaan_impian' => 'Data Engineer',
                'lokasi_magang' => 'Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'mahasiswa_id' => 10, // Jihan Aulia
                'keahlian' => 'Frontend',
                'pekerjaan_impian' => 'Frontend Developer',
                'lokasi_magang' => 'Semarang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
