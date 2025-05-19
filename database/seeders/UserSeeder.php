<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            // Admin Users
            [
                'name' => 'Dr. Siti Nurhalimah',
                'email' => 'admin1@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi, M.Kom',
                'email' => 'admin2@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Dosen Users
            [
                'name' => 'Dr. Ir. Budi Santoso, M.T.',
                'email' => 'budi.santoso@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Prof. Dr. Ani Widiastuti, M.Kom.',
                'email' => 'ani.widiastuti@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Eng. Cahyo Prianto, S.T., M.T.',
                'email' => 'cahyo.prianto@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dra. Dewi Sartika, M.Si.',
                'email' => 'dewi.sartika@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ir. Eko Prasetyo, M.Kom.',
                'email' => 'eko.prasetyo@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dr. Fitri Handayani, S.Kom., M.T.',
                'email' => 'fitri.handayani@university.edu',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Mahasiswa Users
            [
                'name' => 'Andi Kurniawan',
                'email' => 'andi.kurniawan@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bella Safitri',
                'email' => 'bella.safitri@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Candra Wijaya',
                'email' => 'candra.wijaya@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diana Puspitasari',
                'email' => 'diana.puspita@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eko Setiawan',
                'email' => 'eko.setiawan@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fira Ramadhani',
                'email' => 'fira.ramadhan@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gilang Pratama',
                'email' => 'gilang.pratama@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hana Permata',
                'email' => 'hana.permata@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indra Saputra',
                'email' => 'indra.saputra@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jihan Aulia',
                'email' => 'jihan.aulia@student.edu',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
