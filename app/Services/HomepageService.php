<?php

namespace App\Services;

use App\Models\Pricing;
use App\Models\Client;
use App\Models\AboutUsBlock;
use App\Models\Advantage;
use App\Models\HomepageInfo;
use Illuminate\Support\Facades\Storage;

class HomepageService
{

    public function getHomepage(int $languageId): array
    {
        $homepageInfo = $this->getHomepageInfo($languageId);
        $pricelist = $this->getPricelist($languageId);
        $customers = $this->getCustomers($languageId);
        $aboutUsBlocks = $this->getAboutUsBlocks($languageId);
        $advantages = $this->getAdvantages($languageId);


        $result = [
            'hero' => [
                "title" => $homepageInfo['title'] ?? '',
                "description" => $homepageInfo['description'] ?? '',
                "images" => $homepageInfo['images'] ?? [],
            ],
            'advantages' => [
                'title' => $homepageInfo['advantages_title'] ?? '',
                'descriptionList' => $advantages['descriptions'] ?? [],
                'marqueeCarouseles' => $advantages['carousels'] ?? [],
            ],
            'aboutus' => [
                'title' => $homepageInfo['aboutus_title'] ?? '',
                'description' => $homepageInfo['aboutus_description'] ?? '',
                'cards' => $aboutUsBlocks,
            ],
            'services' => [
                'title' => $homepageInfo['pricelist_title'] ?? '',
                'description' => $homepageInfo['pricelist_description'] ?? '',
                'items' => $pricelist,
            ],
            'customers' => [
                'description' => $homepageInfo['customers_description'] ?? '',
                'items' => $customers,
            ],
        ];

        return $result;
    }

    private function getPricelist(int $languageId): array
    {
        try {
            $pricelist = Pricing::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('id', 'title', 'priceFrom', 'time', 'shortDescription', 'isHighlighted')
                ->get();

            if ($pricelist->isEmpty()) {
                return [];
            }

            return $pricelist->toArray();
        } catch (\Exception $e) {
//            throw new \RuntimeException('Internal server error', 500, $e);
            return [];
        }
    }

    private function getCustomers(int $languageId): array
    {
        try {
            $customers = Client::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('image', 'url')
                ->get();

            if ($customers->isEmpty()) {
                return [];
            }

            $customers->each(function ($client) {
                if ($client->image) {
                    $client->image = Storage::disk('public')->url($client->image);
                }
            });

            return $customers->toArray();
        } catch (\Exception $e) {
//            throw new \RuntimeException('Internal server error', 500, $e);
            return [];
        }
    }

    private function getAboutUsBlocks(int $languageId): array
    {
        try {
            $aboutUsBlocks = AboutUsBlock::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('subtitle', 'title', 'description')
                ->get();

            if ($aboutUsBlocks->isEmpty()) {
                throw new \Exception('aboutUsBlocks is empty');
            }

            return $aboutUsBlocks->toArray() ?? [];
        } catch (\Exception $e) {
//            throw new \RuntimeException('Internal server error', 500, $e);
            return [];
        }
    }

    private function getAdvantages(int $languageId): array
    {
        try {
            $advantages = Advantage::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select('descriptions', 'carousels')
                ->first();

            if (!$advantages) {
                return [];
            }

            $advantages->carousels = array_map(function ($item) {
                return $item['carousel'];
            }, $advantages->carousels);

            return $advantages->toArray();
        } catch (\Exception $e) {
//            throw new \RuntimeException('Internal server error', 500, $e);
            return [];
        }
    }

    private function getHomepageInfo(int $languageId): array
    {
        try {
            $homepageInfo = HomepageInfo::where('isActive', true)
                ->where('language_id', $languageId)
                ->orderBy('sort')
                ->select(
                    'title',
                    'description',
                    'images',
                    'advantages_title',
                    'advantages_description',
                    'aboutus_title',
                    'aboutus_description',
                    'pricelist_title',
                    'pricelist_description',
                    'customers_title',
                    'customers_description',
                )
                ->first();

            if (!$homepageInfo) {
                return [];
            }

            $homepageInfo['images'] = array_map(function ($image) {
                return Storage::disk('public')->url($image);
            }, $homepageInfo['images']);

            return $homepageInfo->toArray();
        } catch (\Exception $e) {
//            throw new \RuntimeException('Internal server error', 500, $e);
            return [];
        }
    }
}
