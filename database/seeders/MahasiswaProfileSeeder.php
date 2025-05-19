<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('mahasiswa_profiles')->insert([
            [
                'user_id' => 9, // Andi Kurniawan
                'nim' => '210103001',
                'program_studi_id' => 1,
                'semester' => 6,
                'alamat' => 'Jl. Soekarno Hatta No. 15, Malang',
                'status_magang' => 'Tidak magang',
                'foto_path' => 'foto/andi_kurniawan.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 10, // Bella Safitri
                'nim' => '210103002',
                'program_studi_id' => 1,
                'semester' => 6,
                'alamat' => 'Jl. Veteran No. 8, Malang',
                'status_magang' => 'Sedang magang',
                'foto_path' => 'foto/bella_safitri.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 11, // Candra Wijaya
                'nim' => '210203001',
                'program_studi_id' => 2,
                'semester' => 6,
                'alamat' => 'Jl. Ahmad Yani No. 22, Malang',
                'status_magang' => 'Selesai magang',
                'foto_path' => 'foto/candra_wijaya.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 12, // Diana Puspitasari
                'nim' => '210203002',
                'program_studi_id' => 2,
                'semester' => 4,
                'alamat' => 'Jl. Kertanegara No. 5, Malang',
                'status_magang' => 'Tidak magang',
                'foto_path' => 'foto/diana_puspitasari.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 13, // Eko Setiawan
                'nim' => '210303001',
                'program_studi_id' => 3,
                'semester' => 6,
                'alamat' => 'Jl. Brawijaya No. 12, Malang',
                'status_magang' => 'Sedang magang',
                'foto_path' => 'foto/eko_setiawan.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 14, // Fira Ramadhani
                'nim' => '210303002',
                'program_studi_id' => 3,
                'semester' => 4,
                'alamat' => 'Jl. Candi Badut No. 18, Malang',
                'status_magang' => 'Tidak magang',
                'foto_path' => 'foto/fira_ramadhani.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 15, // Gilang Pratama
                'nim' => '210403001',
                'program_studi_id' => 4,
                'semester' => 6,
                'alamat' => 'Jl. Mayjen Panjaitan No. 25, Malang',
                'status_magang' => 'Selesai magang',
                'foto_path' => 'foto/gilang_pratama.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 16, // Hana Permata
                'nim' => '210403002',
                'program_studi_id' => 4,
                'semester' => 4,
                'alamat' => 'Jl. Diponegoro No. 30, Malang',
                'status_magang' => 'Tidak magang',
                'foto_path' => 'foto/hana_permata.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 17, // Indra Saputra
                'nim' => '210503001',
                'program_studi_id' => 5,
                'semester' => 6,
                'alamat' => 'Jl. Tugu No. 7, Malang',
                'status_magang' => 'Sedang magang',
                'foto_path' => 'foto/indra_saputra.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 18, // Jihan Aulia
                'nim' => '210503002',
                'program_studi_id' => 5,
                'semester' => 4,
                'alamat' => 'Jl. Sunandar Priyo Sudarmo No. 14, Malang',
                'status_magang' => 'Tidak magang',
                'foto_path' => 'foto/jihan_aulia.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
