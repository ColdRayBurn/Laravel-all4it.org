<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Advantage;
use App\Models\AboutUsBlock;
use App\Models\Client;
use App\Models\HomepageInfo;
use App\Models\Language;
use App\Models\Pricing;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomepageControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Добавление языков в базу данных
        $this->seed(\Database\Seeders\LanguageSeeder::class);
    }

    public function test_homepage_controller_returns_correct_structure(): void
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');

        HomepageInfo::factory()->create(['language_id' => $languageId, 'isActive' => true]);
        Pricing::factory()->count(3)->create(['language_id' => $languageId, 'isActive' => true]);
        Client::factory()->count(2)->create(['language_id' => $languageId, 'isActive' => true]);
        AboutUsBlock::factory()->count(3)->create(['language_id' => $languageId, 'isActive' => true]);
        Advantage::factory()->create(['language_id' => $languageId, 'isActive' => true]);

        // Act
        $response = $this->getJson('/api/v1/homepage');

        // Assert
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'hero',
            'advantages',
            'aboutus',
            'services',
            'customers',
        ]);
    }
}
