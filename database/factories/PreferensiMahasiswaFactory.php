<?php

namespace Database\Factories;

use App\Models\Kriteria;
use App\Models\Mahasiswa;
use App\Models\PreferensiMahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreferensiMahasiswa>
 */
class PreferensiMahasiswaFactory extends Factory
{
    protected $model = PreferensiMahasiswa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mahasiswa_id' => fn() => Mahasiswa::inRandomOrder()->value('id'),
            'skil' => fn() => Kriteria::inRandomOrder()->value('id'),
            'bidang_industri' => fn() => Kriteria::inRandomOrder()->value('id'),
            'lokasi' => fn() => Kriteria::inRandomOrder()->value('id'),
            'uang_saku' => fn() => Kriteria::inRandomOrder()->value('id'),
            'open_remote' => fn() => Kriteria::inRandomOrder()->value('id'),
        ];
    }
}
