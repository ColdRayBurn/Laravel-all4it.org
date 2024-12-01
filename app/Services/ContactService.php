<?php

namespace App\Services;

use App\Models\Contact;

class ContactService
{
    public function getContactInfo(int $languageId): ?Contact
    {
        try {
            $item = Contact::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('title', 'content')
                ->first();

            if (!$item) {
                return null;
            }

            return $item;
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }

}
