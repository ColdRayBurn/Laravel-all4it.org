<?php

namespace App\Filament\Resources\GlobalInfoResource\Pages;

use App\Filament\Resources\GlobalInfoResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGlobalInfo extends CreateRecord
{
    protected static string $resource = GlobalInfoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['page_description'] = Helper::removeOuterPTag($data['page_description']);

        return $data;
    }
}
