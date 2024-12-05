<?php

namespace App\Services;

use App\Models\PortfolioItem;
use DateTime;
use Illuminate\Support\Facades\Storage;

class PortfolioService
{
    public function getAll(int $languageId): array
    {
        try {
            $items = PortfolioItem::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('id', 'logotype', 'shortDescription')
                ->get();

            $items->each(function ($item) {
                if ($item->logotype) {
                    $item->logotype = Storage::disk('public')->url($item->logotype);
                }
            });

            return $items->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }

    public function getById(int $id): ?PortfolioItem
    {
        try {
            $item = PortfolioItem::where('id', $id)
                ->where('isActive', true)
                ->select('id', 'logotype', 'title', 'shortDescription', 'secondShortDescription',
                    'description', 'url', 'developmentDate', 'gallery')
                ->first();

            if (!$item) {
                return null;
            }

            if ($item->gallery) {
                $item->gallery = array_map(function ($image) {
                    return Storage::disk('public')->url($image);
                }, $item->gallery);
            }
            if ($item->logotype) {
                $item->logotype = Storage::disk('public')->url($item->logotype);
            }

            $date = DateTime::createFromFormat('Y-m-d', $item->developmentDate);
            $item->developmentDate = $date ? strtotime($date->format('Y-m-d 00:00:00')) : null; // Если дата валидна, получаем timestamp

            return $item;
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }
}
