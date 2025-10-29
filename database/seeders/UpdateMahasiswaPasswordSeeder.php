<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Hash;

class UpdateMahasiswaPasswordSeeder extends Seeder
{
    public function run(): void
    {
        $mahasiswa = Mahasiswa::where('nim', '6705300038')->first();
        
        if ($mahasiswa) {
            $mahasiswa->password = Hash::make('mahasiswa123');
            $mahasiswa->save();
            
            $this->command->info('✅ Password updated for NIM: ' . $mahasiswa->nim);
            $this->command->info('   Nama: ' . $mahasiswa->nama);
            $this->command->info('   Email: ' . $mahasiswa->email);
            $this->command->info('   Password: mahasiswa123 (hashed)');
        } else {
            $this->command->error('❌ Mahasiswa with NIM 6705300038 not found!');
        }
    }
}
