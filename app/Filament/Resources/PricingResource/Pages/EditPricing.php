<?php

namespace App\Filament\Resources\PricingResource\Pages;

use App\Filament\Resources\PricingResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPricing extends EditRecord
{
    protected static string $resource = PricingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['shortDescription'] = Helper::removeOuterPTag($data['shortDescription']);

        return $data;
    }
}
