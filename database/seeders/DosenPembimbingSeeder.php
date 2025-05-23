<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenPembimbingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dosen_pembimbing')->insert([
            [
                'nama' => 'Dr. Ahmad Fauzi, M.Kom',
                'nidn' => '0012067801',
                'password' => Hash::make('dosen123'),
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Dr. Siti Nurhaliza, M.T',
                'nidn' => '0015087502',
                'password' => Hash::make('dosen123'),
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Prof. Dr. Bambang Sutrisno, M.Si',
                'nidn' => '0020056503',
                'password' => Hash::make('dosen123'),
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Dr. Rina Kartika, M.M',
                'nidn' => '0025068004',
                'password' => Hash::make('dosen123'),
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Dr. Ir. Hadi Wijaya, M.T',
                'nidn' => '0030057505',
                'password' => Hash::make('dosen123'),
                'jenis_kelamin' => 'L'
            ],
        ]);
    }
}
