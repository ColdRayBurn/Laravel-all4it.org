<?php

namespace App\Services;

use App\Models\Feedback;
use App\Mail\FeedbackSubmitted;
use Illuminate\Support\Facades\Mail;

class FeedbackService
{
    private string $adminMail = 'themichaelchannel@gmail.com';

    public function createFeedback(array $data): void
    {
        try {
            // Преобразуем данные
            $data['phoneNumber'] = $data['phonenumber'];
            unset($data['phonenumber']);

            // Создаем запись в базе данных
            $feedback = Feedback::create($data);

            // Отправляем email
            $this->sendFeedbackEmail($feedback);
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }

    private function sendFeedbackEmail(Feedback $feedback): void
    {
        Mail::to($this->adminMail)
            ->send(new FeedbackSubmitted($feedback->toArray()));
    }
}
