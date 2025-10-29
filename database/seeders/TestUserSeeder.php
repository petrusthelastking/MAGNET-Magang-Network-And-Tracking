<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Mahasiswa;
use App\Models\Perusahaan;
use App\Models\DosenPembimbing;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder ini digunakan untuk membuat user testing untuk Playwright E2E tests
     */
    public function run(): void
    {
        // Create Admin Test User
        try {
            Admin::firstOrCreate(
                ['nip' => 'ADMIN001'],
                [
                    'nama' => 'Admin Test',
                    'password' => Hash::make('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $this->command->info('✓ Admin test user created/found: ADMIN001 / password');
        } catch (\Exception $e) {
            $this->command->warn('⚠ Could not create Admin: ' . $e->getMessage());
        }

        // Create Mahasiswa Test User
        try {
            Mahasiswa::firstOrCreate(
                ['nim' => 'TEST123456'],
                [
                    'nama' => 'Mahasiswa Test',
                    'email' => 'mahasiswa.test@example.com',
                    'password' => Hash::make('password'),
                    'angkatan' => 2022,
                    'jenis_kelamin' => 'L',
                    'tanggal_lahir' => '2002-01-01',
                    'jurusan' => 'Teknologi Informasi',
                    'program_studi' => 'D4 Teknik Informatika',
                    'status_magang' => 'belum magang',
                    'alamat' => 'Jl. Test No. 1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $this->command->info('✓ Mahasiswa test user created/found: TEST123456 / password');
        } catch (\Exception $e) {
            $this->command->warn('⚠ Could not create Mahasiswa: ' . $e->getMessage());
        }

        // Create Dosen Pembimbing Test User (if needed)
        try {
            DosenPembimbing::firstOrCreate(
                ['nip' => 'DOSEN001'],
                [
                    'nama' => 'Dr. Dosen Test',
                    'password' => Hash::make('password'),
                    'no_telp' => '081234567893',
                    'jurusan' => 'Teknik Informatika',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $this->command->info('✓ Dosen test user created/found: DOSEN001 / password');
        } catch (\Exception $e) {
            $this->command->warn('⚠ Could not create Dosen: ' . $e->getMessage());
        }

        $this->command->info("\n✅ Test user seeding completed!");
        $this->command->info('Use these credentials for Playwright E2E testing');
    }
}
