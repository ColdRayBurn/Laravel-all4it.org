<?php

namespace App\Services;

use App\Models\Pricing;


class ServiceService
{
    public function getAll(int $languageId): array
    {
        try {
            $items = Pricing::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('id', 'title', 'priceFrom', 'time', 'shortDescription') //, 'image'
                ->get();

            return $items->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }

    public function getById(int $id): ?Pricing
    {
        try {
            $item = Pricing::where('id', $id)
                ->where('isActive', true)
                ->select('id', 'title', 'priceFrom', 'time', 'description')
                ->first();

            return $item;
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }
}
