<?php

namespace App\Services;

use App\Models\GlobalInfo;
use Illuminate\Support\Facades\Storage;

class GlobalInfoService
{
    public function getGlobalInfo(int $languageId): array
    {
        try {
            $item = GlobalInfo::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select(
                    'page_title',
                    'page_description',
                    'logotype',
                    'contacts',
                    'footer_title',
                )
                ->first();


            if ($item && $item->logotype) {
                $item->logotype = Storage::disk('public')->url($item->logotype);
            }

            // Преобразуем массив контактов в нужную структуру
            if ($item && $item->contacts) {
                $transformedContacts = [];
                foreach ($item->contacts as $contact) {
                    if (isset($contact['contact_type'])) {
                        $transformedContacts[$contact['contact_type']] = $contact['value'];
                    }
                }
            }


            $result = [
                'page' => [
                    'title' => $item->page_title ?? '',
                    'description' => $item->page_description ?? '',
                ],
                "logotype" => $item->logotype ?? '',
                "contacts" => $transformedContacts ?? [],
                "footer" => [
                    'title' => $item->footer_title ?? '',
                ]
            ];

            return $result;
        } catch (\Exception $e) {
//            throw new \RuntimeException('Internal server error', 500, $e);
            return [];
        }
    }

}
