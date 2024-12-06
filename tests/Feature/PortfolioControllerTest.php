<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\Language;
use App\Models\PortfolioItem;


class PortfolioControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Добавление языков в базу данных
        $this->seed(\Database\Seeders\LanguageSeeder::class);
    }

    public function test_portfolio_controller_can_return_all_portfolio_items()
    {
        // Arrange
        $languageId = Language::where('code', 'ru')->value('id');
        \Database\Factories\PortfolioFactory::new()->count(3)->create(['language_id' => $languageId, 'isActive' => true]);

        // Act
        $response = $this->withHeaders([
            'Accept-Language' => 'ru',
        ])->getJson('/api/v1/projects');

        // Assert
        $response->assertStatus(200);
        // Проверяем, что в массиве данных три элемента
        $response->assertJsonCount(3, '*');
        // Проверяем структуру каждого элемента в массиве
        $response->assertJsonStructure([
            '*' => [
                'id',
                'logotype',
                'shortDescription',
            ]
        ]);
    }

    public function test_portfolio_controller_can_returns_items_according_to_accept_language_header()
    {
        // Arrange
        $ru = Language::where('code', 'ru')->value('id');
        \Database\Factories\PortfolioFactory::new()->count(3)->create(['language_id' => $ru, 'isActive' => true]);
        $en = Language::where('code', 'en')->value('id');
        \Database\Factories\PortfolioFactory::new()->count(4)->create(['language_id' => $en, 'isActive' => true]);

        // Act
        $response = $this->withHeaders([
            'Accept-Language' => 'en',
        ])->getJson('/api/v1/projects');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(4, '*');
    }

    public function test_portfolio_controller_can_return_single_portfolio_item()
    {
        // Arrange
        $languageId = Language::where('code', 'ru')->value('id');
        $portfolioItem = \Database\Factories\PortfolioFactory::new()->create([
            'language_id' => $languageId, 'isActive' => true,
            'shortDescription' => 'test short description',
            'title' => 'test',
        ]);

        // Act
        $response = $this->getJson('/api/v1/projects/' . $portfolioItem->id);

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'logotype',
            'title',
            'shortDescription',
            'secondShortDescription',
            'description',
            'url',
            'developmentDate',
            'gallery',
        ]);
    }

    public function test_portfolio_controller_returns_not_found_when_portfolio_item_does_not_exist()
    {
        // Act
        $response = $this->getJson('/api/v1/projects/999'); // ID не существует

        // Assert
        $response->assertStatus(404);
        $response->assertJson([
            'message' => 'portfolio item not found',
        ]);
    }

}
