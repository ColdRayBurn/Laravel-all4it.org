<?php

namespace App\Filament\Resources\PricingResource\Pages;

use App\Filament\Resources\PricingResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePricing extends CreateRecord
{
    protected static string $resource = PricingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['shortDescription'] = Helper::removeOuterPTag($data['shortDescription']);

        return $data;
    }
}
