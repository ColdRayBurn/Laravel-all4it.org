<?php

namespace App\Services;

use App\Models\Privacy;


class PrivacyService
{
    public function getPrivacyPolicy(int $languageId): ?Privacy
    {
        try {
            $item = Privacy::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('content')
                ->first();

            return $item;
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }
}
