<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\HomepageService;
use App\Models\Pricing;
use App\Models\Client;
use App\Models\AboutUsBlock;
use App\Models\Advantage;
use App\Models\HomepageInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class HomepageServiceTest extends TestCase
{
    use RefreshDatabase;

    private HomepageService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new HomepageService();

        // Добавление языков в базу данных
        $this->seed(\Database\Seeders\LanguageSeeder::class);

    }


    public function test_get_homepage_aggregates_all_data_correctly()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');

        HomepageInfo::factory()->create(['language_id' => $languageId, 'isActive' => true]);
        Pricing::factory()->count(3)->create(['language_id' => $languageId, 'isActive' => true]);
        Client::factory()->count(2)->create(['language_id' => $languageId, 'isActive' => true]);
        AboutUsBlock::factory()->count(3)->create(['language_id' => $languageId, 'isActive' => true]);
        Advantage::factory()->create(['language_id' => $languageId, 'isActive' => true]);

        // Act
        $result = $this->service->getHomepage($languageId);

        // Assert
        $this->assertNotEmpty($result);
        $this->assertArrayHasKey('hero', $result);
        $this->assertArrayHasKey('advantages', $result);
        $this->assertArrayHasKey('aboutus', $result);
        $this->assertArrayHasKey('services', $result);
        $this->assertArrayHasKey('customers', $result);
    }

    public function test_get_pricelist_returns_correct_data()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');

        Pricing::factory()->count(3)->create([
            'language_id' => $languageId,
            'isActive' => true,
        ]);

        // Act
        $result = $this->service->getHomepage($languageId);

        // Assert
        $this->assertArrayHasKey('services', $result);
        $this->assertCount(3, $result['services']['items']);

        foreach ($result['services']['items'] as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('priceFrom', $item);
        }
    }

    public function test_get_customers_returns_correct_data()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');
        Client::factory()->count(2)->create([
            'language_id' => $languageId,
            'isActive' => true,
        ]);

        // Act
        $result = $this->service->getHomepage($languageId);

        // Assert
        $this->assertArrayHasKey('customers', $result);
        $this->assertCount(2, $result['customers']['items']);
        foreach ($result['customers']['items'] as $item) {
            $this->assertArrayHasKey('image', $item);
            $this->assertArrayHasKey('url', $item);
        }
    }

    public function test_get_about_us_blocks_returns_correct_data()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');

        AboutUsBlock::factory()->count(3)->create([
            'language_id' => $languageId,
            'isActive' => true,
        ]);

        // Act
        $result = $this->service->getHomepage($languageId);

        // Assert
        $this->assertArrayHasKey('aboutus', $result);
        $this->assertCount(3, $result['aboutus']['cards']);
        foreach ($result['aboutus']['cards'] as $item) {
            $this->assertArrayHasKey('subtitle', $item);
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('description', $item);
        }
    }

    public function test_get_advantages_returns_correct_data()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');

        Advantage::factory()->count(3)->create([
            'language_id' => $languageId,
            'isActive' => true,
            'descriptions' => ['one', 'two', 'three'],
            'carousels' => [
                ['carousel' => ['1', '2']],
                ['carousel' => ['qwerty', 'asdfgh', 'zxcvbn']],
            ],
        ]);

        // Act
        $result = $this->service->getHomepage($languageId);

        // Assert
        $this->assertArrayHasKey('advantages', $result);

        $this->assertCount(3, $result['advantages']['descriptionList']);
        $this->assertCount(2, $result['advantages']['marqueeCarouseles'][0]);
        $this->assertCount(3, $result['advantages']['marqueeCarouseles'][1]);
    }
}
