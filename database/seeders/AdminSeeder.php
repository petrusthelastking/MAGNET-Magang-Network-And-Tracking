<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin')->insert([
            [
                'nama' => 'Administrator',
                'nip' => '198501012010011001',
                'password' => Hash::make('admin123')
            ],
            [
                'nama' => 'Dwi Setiyaningsih',
                'nip' => '198707152012032002',
                'password' => Hash::make('admin123')
            ],
        ]);
    }
}
