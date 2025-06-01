<?php

namespace Database\Factories;

use App\Models\BerkasPengajuanMagang;
use App\Models\FormPengajuanMagang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FormPengajuanMagang>
 */
class FormPengajuanMagangFactory extends Factory
{
    protected $model = FormPengajuanMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pengajuan_id' => fn() => BerkasPengajuanMagang::inRandomOrder()->value('id'),
            'status' => $this->faker->randomElement(['diproses', 'diterima', 'ditolak']),
            'keterangan' => $this->faker->sentence()
        ];
    }
}
