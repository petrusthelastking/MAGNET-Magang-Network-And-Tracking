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
                'email' => 'andi.pratama@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2002-05-10',
                'angkatan' => 23,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Teknik Informatika',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Sudirman No. 123, Jakarta Pusat'
            ],
            [
                'nama' => 'Sari Dewi Lestari',
                'nim' => '2021001002',
                'email' => 'sari.lestari@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2001-07-18',
                'angkatan' => 24,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'sedang magang',
                'alamat' => 'Jl. Malioboro No. 45, Yogyakarta'
            ],
            [
                'nama' => 'Budi Santoso',
                'nim' => '2021001003',
                'email' => 'budi.santoso@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2000-03-22',
                'angkatan' => 25,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D2 Pengembangan Piranti Lunak Situs',
                'status_magang' => 'selesai magang',
                'alamat' => 'Jl. Dago No. 67, Bandung'
            ],
            [
                'nama' => 'Maya Sari',
                'nim' => '2021001004',
                'email' => 'maya.sari@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2003-09-14',
                'angkatan' => 23,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Thamrin No. 89, Jakarta Selatan'
            ],
            [
                'nama' => 'Rizki Maulana',
                'nim' => '2021001005',
                'email' => 'rizki.maulana@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2002-11-06',
                'angkatan' => 24,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Teknik Informatika',
                'status_magang' => 'sedang magang',
                'alamat' => 'Jl. Imam Bonjol No. 12, Medan'
            ],
            [
                'nama' => 'Fitri Handayani',
                'nim' => '2021001006',
                'email' => 'fitri.handayani@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2001-01-27',
                'angkatan' => 25,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D2 Pengembangan Piranti Lunak Situs',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Diponegoro No. 34, Semarang'
            ],
            [
                'nama' => 'Doni Setiawan',
                'nim' => '2021001007',
                'email' => 'doni.setiawan@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2000-08-30',
                'angkatan' => 25,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'selesai magang',
                'alamat' => 'Jl. Ahmad Yani No. 56, Surabaya'
            ],
            [
                'nama' => 'Ratna Wulandari',
                'nim' => '2021001008',
                'email' => 'ratna.wulandari@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-12-03',
                'angkatan' => 27,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Teknik Informatika',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Veteran No. 78, Malang'
            ],
            [
                'nama' => 'Agus Susanto',
                'nim' => '2021001009',
                'email' => 'agus.susanto@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2003-10-21',
                'angkatan' => 27,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D4 Sistem Informasi Bisnis',
                'status_magang' => 'sedang magang',
                'alamat' => 'Jl. Gajah Mada No. 90, Denpasar'
            ],
            [
                'nama' => 'Lestari Putri',
                'nim' => '2021001010',
                'email' => 'lestari.putri@example.com',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2004-06-15',
                'angkatan' => 27,
                'jurusan' => 'Teknologi Informasi',
                'program_studi' => 'D2 Pengembangan Piranti Lunak Situs',
                'status_magang' => 'belum magang',
                'alamat' => 'Jl. Pandanaran No. 123, Solo'
            ],
        ]);
    }
}
