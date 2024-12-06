<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

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
            'name' => $this->faker->word,
            'image' => $this->faker->lexify('client_image_????.jpg'),
            'url' => $this->faker->url,
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
