<?php

namespace Database\Factories;

use App\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PortfolioItem>
 */
class PortfolioFactory extends Factory
{
    protected $model = PortfolioItem::class;
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
            'logotype' => $this->faker->lexify('logotype_????.jpg'),
            'shortDescription' => $this->faker->sentence(5),
            'title' => $this->faker->sentence(3),
            'secondShortDescription' => $this->faker->sentence(8),
            'description' => $this->faker->paragraph,
            'url' => $this->faker->url(),
            'developmentDate' => now()->subYear(),
            'gallery' => [$this->faker->lexify('gallery_????.jpg'),
                $this->faker->lexify('gallery_????.jpg')],
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
