<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'nama' => 'Andi Pratama',
                'nim' => '2021001001',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'umur' => 21,
                'angkatan' => 23,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Teknik Informatika',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat'
            ],
            [
                'nama' => 'Sari Dewi Lestari',
                'nim' => '2021001002',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'umur' => 22,
                'angkatan' => 24,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'sedang magang',
                'alamat' => 'Jl. Malioboro No. 45, Yogyakarta'
            ],
            [
                'nama' => 'Budi Santoso',
                'nim' => '2021001003',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'umur' => 23,
                'angkatan' => 25,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D2 Pengembangan Piranti Lunak Situs',
                'status_magang' => 'selesai magang',
                'alamat' => 'Jl. Dago No. 67, Bandung'
            ],
            [
                'nama' => 'Maya Sari',
                'nim' => '2021001004',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'umur' => 20,
                'angkatan' => 23,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Thamrin No. 89, Jakarta Selatan'
            ],
            [
                'nama' => 'Rizki Maulana',
                'nim' => '2021001005',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'umur' => 21,
                'angkatan' => 24,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Teknik Informatika',
                'status_magang' => 'sedang magang',
                'alamat' => 'Jl. Imam Bonjol No. 12, Medan'
            ],
            [
                'nama' => 'Fitri Handayani',
                'nim' => '2021001006',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'umur' => 22,
                'angkatan' => 25,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D2 Pengembangan Piranti Lunak Situs',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Diponegoro No. 34, Semarang'
            ],
            [
                'nama' => 'Doni Setiawan',
                'nim' => '2021001007',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'umur' => 23,
                'angkatan' => 25,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'selesai magang',
                'alamat' => 'Jl. Ahmad Yani No. 56, Surabaya'
            ],
            [
                'nama' => 'Ratna Wulandari',
                'nim' => '2021001008',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'umur' => 19,
                'angkatan' => 27,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Teknik Informatika',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Veteran No. 78, Malang'
            ],
            [
                'nama' => 'Agus Susanto',
                'nim' => '2021001009',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'umur' => 20,
                'angkatan' => 27,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'sedang magang',
                'alamat' => 'Jl. Gajah Mada No. 90, Denpasar'
            ],
            [
                'nama' => 'Lestari Putri',
                'nim' => '2021001010',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'umur' => 19,
                'angkatan' => 27,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D2 Pengembangan Piranti Lunak Situs',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Pandanaran No. 123, Solo'
            ],
        ]);
    }
}
