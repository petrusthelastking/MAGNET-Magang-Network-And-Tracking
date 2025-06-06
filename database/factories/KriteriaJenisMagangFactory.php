<?php

namespace Database\Factories;

use App\Enums\DecisionMakingEnum;
use App\Helpers\DecisionMaking\ROC;
use App\Models\KriteriaJenisMagang;
use App\Models\Mahasiswa;
use App\Traits\BaseKriteriaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KriteriaJenisMagang>
 */
class KriteriaJenisMagangFactory extends Factory
{
    use BaseKriteriaFactory;

    protected $model = KriteriaJenisMagang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rank = $this->faker->numberBetween(1, DecisionMakingEnum::totalCriteria->value);

        return [
            'jenis_magang' => $this->faker->randomElement(['berbayar', 'tidak berbayar']),
            'mahasiswa_id' => fn() => Mahasiswa::inRandomOrder()->value('id'),
            'rank' => $rank,
            'bobot' => ROC::getWeight($rank, DecisionMakingEnum::totalCriteria->value)
        ];
    }
}
