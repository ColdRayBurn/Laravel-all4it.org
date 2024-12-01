<?php

namespace App\Filament\Resources\AboutUsBlockResource\Pages;

use App\Filament\Resources\AboutUsBlockResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutUsBlock extends CreateRecord
{
    protected static string $resource = AboutUsBlockResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['description'] = Helper::removeOuterPTag($data['description']);

        return $data;
    }
}
