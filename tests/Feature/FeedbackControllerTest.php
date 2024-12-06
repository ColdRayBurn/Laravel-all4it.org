<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Feedback;
use Illuminate\Support\Facades\Mail;

class FeedbackControllerTest extends TestCase
{
    use RefreshDatabase;


    public function test_feedback_can_be_created_successfully()
    {
        // Arrange
        Mail::fake(); // Mock отправки почты

        $payload = [
            'name' => 'Иван Иванов',
            'email' => 'test@test.com',
            'companyName' => 'Test Company',
            'phonenumber' => '+71234567890',
            'comment' => 'Тестовый комментарий.',
        ];

        // Act
        $response = $this->postJson('/api/v1/feedback', $payload);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Feedback created',
        ]);

        // Проверяем, что запись появилась в базе данных
        $this->assertDatabaseHas('feedback', [
            'name' => $payload['name'],
            'email' => $payload['email'],
            'companyName' => $payload['companyName'],
            'phoneNumber' => $payload['phonenumber'],
            'comment' => $payload['comment'],
        ]);

        // Проверяем, что письмо отправилось
        Mail::assertSent(\App\Mail\FeedbackSubmitted::class,
            function ($mail) use ($payload) {
                // $mail->hasTo('themichaelchannel@gmail.com')
                return $mail->data['name'] === $payload['name'] &&
                    $mail->data['email'] === $payload['email'] &&
                    $mail->data['companyName'] === $payload['companyName'] &&
                    $mail->data['comment'] === $payload['comment'];
            });
    }

    public function test_feedback_validation_errors()
    {
        // Act
        $response = $this->postJson('/api/v1/feedback', []);

        // Assert
        $response->assertStatus(400);
        $response->assertJson([
            'success' => false,
            'message' => 'Data validation error',
        ]);

        $response->assertJsonStructure([
            'errors' => [
                'name',
                'email',
                'companyName',
                'phonenumber',
                'comment',
            ],
        ]);
    }
}
