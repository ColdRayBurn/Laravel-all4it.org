<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
//            'id' => $this->faker->,
            'language_id' => \App\Models\Language::where('code', 'ru')->value('id'),
            'isActive' => true,
            'title' => $this->faker->sentence,
            'image' => $this->faker->lexify('blog_image_????.jpg'),
            'content' => $this->faker->paragraph,
            'publishDatetime' => now()->subDays(rand(0, 30)),
            'sort' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
