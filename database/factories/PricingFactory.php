<?php

namespace Database\Factories;

use App\Models\Pricing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pricing>
 */
class PricingFactory extends Factory
{
    protected $model = Pricing::class;

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
            'title' => $this->faker->sentence,
            'priceFrom' => $this->faker->numberBetween(20000, 300000),
            'time' => $this->faker->numberBetween(2, 30) . ' дней',
            'shortDescription' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'isHighlighted' => $this->faker->boolean,
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
