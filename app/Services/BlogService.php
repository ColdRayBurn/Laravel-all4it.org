<?php

namespace App\Services;

use App\Models\Blog;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    public function getAll(int $languageId): array
    {
        try {
            $items = Blog::where('isActive', true)
                ->where('language_id', $languageId)
                ->where('publishDatetime', '<=', date('Y-m-d H:i:s'))
                ->orderBy('sort')
                ->select('id', 'title', 'image', 'publishDatetime')
                ->get();

            $items->each(function ($item) {
                if ($item->image) {
                    $item->image = Storage::disk('public')->url($item->image);
                }
            });

            // Преобразуем строку даты и времени в timestamp
            $items->each(function ($item) {
                if ($item->publishDatetime) {
                    $date = DateTime::createFromFormat('Y-m-d H:i:s', $item->publishDatetime);
                    $item->publishDatetime = $date ? strtotime($date->format('Y-m-d H:i:0')) : null;
                }
            });

            return $items->toArray();
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }

    public function getById(string $id): ?Blog
    {
        try {
            $item = Blog::where('id', $id)
                ->where('isActive', true)
                ->select('id', 'title', 'image', 'content', 'publishDatetime')
                ->first();

            if (!$item) {
                return null;
            }

            if ($item->image) {
                $item->image = Storage::disk('public')->url($item->image);
            }

            // Преобразуем строку даты в timestamp
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $item->publishDatetime);
            $item->publishDatetime = $date ? strtotime($date->format('Y-m-d H:i:0')) : null;


            return $item;
        } catch (\Exception $e) {
            throw new \RuntimeException('Internal server error', 500, $e);
        }
    }
}
