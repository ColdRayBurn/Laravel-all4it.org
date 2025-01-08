<?php

namespace App\Services;

use App\Models\Feedback;
use App\Mail\FeedbackSubmitted;
use Illuminate\Support\Facades\Mail;

class FeedbackService
{

    public function createFeedback(array $data): void
    {
        try {
            // Преобразуем данные
            if (isset($data['phonenumber'])){
                $data['phoneNumber'] = $data['phonenumber'];
                unset($data['phonenumber']);
            }

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
        Mail::to(env('ADMIN_EMAIL'))
            ->queue(new FeedbackSubmitted($feedback->toArray()));
    }
}
