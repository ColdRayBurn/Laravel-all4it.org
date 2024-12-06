<?php

namespace Database\Factories;

use App\Models\AboutUsBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AboutUsBlock>
 */
class AboutUsBlockFactory extends Factory
{
    protected $model = AboutUsBlock::class;

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
            'subtitle' => $this->faker->sentence,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
