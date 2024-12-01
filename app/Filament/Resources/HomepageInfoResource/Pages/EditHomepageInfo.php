<?php

namespace App\Filament\Resources\HomepageInfoResource\Pages;

use App\Filament\Resources\HomepageInfoResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomepageInfo extends EditRecord
{
    protected static string $resource = HomepageInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['title'] = Helper::removeOuterPTag($data['title']);
        $data['description'] = Helper::removeOuterPTag($data['description']);
        $data['aboutus_description'] = Helper::removeOuterPTag($data['aboutus_description']);
        $data['advantages_description'] = Helper::removeOuterPTag($data['advantages_description']);
        $data['pricelist_description'] = Helper::removeOuterPTag($data['pricelist_description']);
        $data['customers_description'] = Helper::removeOuterPTag($data['customers_description']);

        return $data;
    }
}
