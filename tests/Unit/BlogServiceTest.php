<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Blog;
use App\Services\BlogService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;


class BlogServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BlogService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new BlogService();


        // Добавление языков в базу данных
        $this->seed(\Database\Seeders\LanguageSeeder::class);

//        \App\Models\Language::query()->delete();
//        DB::statement('ALTER TABLE languages AUTO_INCREMENT = 1;');
//        \App\Models\Language::create(['id' => 1, 'isActive' => true, 'code' => 'ru', 'name' => 'Русский']);
//        \App\Models\Language::create(['id' => 2, 'isActive' => true, 'code' => 'en', 'name' => 'English']);
    }

    public function test_get_all_returns_active_blogs()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');
        Blog::factory()->count(3)->create(['isActive' => true, 'language_id' => $languageId]);
        Blog::factory()->create(['isActive' => false, 'language_id' => $languageId]); // Неактивный

        // Act
        $result = $this->service->getAll($languageId);

        // Assert
        $this->assertCount(3, $result);
    }

    public function test_get_all_filters_by_language_id()
    {
        // Arrange
        Blog::factory()->create(['language_id' => \App\Models\Language::where('code', 'ru')->value('id')]);
        Blog::factory()->create(['language_id' => \App\Models\Language::where('code', 'en')->value('id')]);

        // Act
        $result = $this->service->getAll(\App\Models\Language::where('code', 'ru')->value('id'));

        // Assert
        $this->assertCount(1, $result);
    }

    public function test_get_all_excludes_blogs_with_future_publish_date()
    {
        // Arrange
        $languageId = \App\Models\Language::where('code', 'ru')->value('id');

        Blog::factory()->create([
            'language_id' => $languageId,
            'publishDatetime' => now()->subDay()->format('Y-m-d H:i:s'), // Дата в прошлом
        ]);
        Blog::factory()->create([
            'language_id' => $languageId,
            'publishDatetime' => now()->addDay()->format('Y-m-d H:i:s'), // Дата в будущем
        ]);

        // Act
        $result = $this->service->getAll($languageId);

        // Assert
        $this->assertCount(1, $result); // Только одна запись с датой в прошлом
    }


    public function test_get_by_id_returns_correct_blog()
    {
        // Arrange
        $blog = Blog::factory()->create();

        // Act
        $result = $this->service->getById($blog->id);

        // Assert
        $this->assertNotNull($result);
        $this->assertEquals($blog->id, $result->id);
    }

    public function test_get_by_id_returns_null_for_nonexistent_blog()
    {
        // Act
        $result = $this->service->getById(-99999);

        // Assert
        $this->assertNull($result);
    }

    public function test_get_by_id_returns_null_if_publish_date_in_future()
    {
        // Arrange
        $futureDate = now()->addDays(5)->format('Y-m-d H:i:s'); // Дата в будущем
        $blog = Blog::factory()->create(['publishDatetime' => $futureDate]);

        // Act
        $result = $this->service->getById($blog->id);

        // Assert
        $this->assertNull($result);
    }

    public function test_get_by_id_images_are_correctly_transformed()
    {
        // Arrange
        Storage::fake('public');
        $fileName = 'test-image.jpg';
        $blog = Blog::factory()->create(['image' => $fileName]);

        // Act
        $result = $this->service->getById($blog->id);

        // Assert
        $expectedUrl = Storage::disk('public')->url($fileName);
        $this->assertEquals($expectedUrl, $result->image);
    }

    public function test_get_by_id_publish_datetime_is_transformed_to_timestamp()
    {
        // Arrange
        $datetime = '2024-12-05 10:00:00';
        $blog = Blog::factory()->create(['publishDatetime' => $datetime]);

        // Act
        $result = $this->service->getById($blog->id);

        // Assert
        $this->assertEquals(strtotime($datetime), $result->publishDatetime); // 1701770400
    }
}

