<?php

namespace Database\Factories;

use App\Models\HomepageInfo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HomepageInfo>
 */
class HomepageInfoFactory extends Factory
{
    protected $model = HomepageInfo::class;

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
            'description' => $this->faker->paragraph,
            'images' => [
                $this->faker->lexify('homepage_image_????.jpg'),
                $this->faker->lexify('homepage_image_????.jpg')
            ],
            'advantages_title' => $this->faker->sentence,
            'advantages_description' => $this->faker->paragraph,
            'aboutus_title' => $this->faker->sentence,
            'aboutus_description' => $this->faker->paragraph,
            'pricelist_title' => $this->faker->sentence,
            'pricelist_description' => $this->faker->paragraph,
            'customers_title' => $this->faker->sentence,
            'customers_description' => $this->faker->paragraph,
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
