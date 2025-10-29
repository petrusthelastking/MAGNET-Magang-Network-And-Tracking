<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;

class RealMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder untuk membuat mahasiswa dengan kredensial real untuk testing
     */
    public function run(): void
    {
        try {
            Mahasiswa::firstOrCreate(
                ['nim' => '6705300038'],
                [
                    'nama' => 'Mahasiswa Real Test',
                    'email' => 'mahasiswa.real@example.com',
                    'password' => Hash::make('mahasiswa123'),
                    'angkatan' => 2023,
                    'jenis_kelamin' => 'L',
                    'tanggal_lahir' => '2003-05-15',
                    'jurusan' => 'Teknologi Informasi',
                    'program_studi' => 'D4 Teknik Informatika',
                    'status_magang' => 'belum magang',
                    'alamat' => 'Jl. Real Test No. 123',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $this->command->info('✓ Real Mahasiswa test user created: 6705300038 / mahasiswa123');
        } catch (\Exception $e) {
            $this->command->error('⚠ Could not create Real Mahasiswa: ' . $e->getMessage());
        }
    }
}
