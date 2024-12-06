<?php

namespace Database\Factories;

use App\Models\Advantage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advantage>
 */
class AdvantageFactory extends Factory
{
    protected $model = Advantage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'language_id' => \App\Models\Language::where('code', 'ru')->value('id'),
            'isActive' => true,
            'descriptions' => $this->faker->sentences(rand(3, 6)),
            'carousels' => [
                ['carousel' => $this->faker->sentences(rand(2, 4))],
                ['carousel' => $this->faker->sentences(rand(2, 4))],
            ],
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
