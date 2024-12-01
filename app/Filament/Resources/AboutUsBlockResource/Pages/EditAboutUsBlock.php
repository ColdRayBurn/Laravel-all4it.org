<?php

namespace App\Filament\Resources\AboutUsBlockResource\Pages;

use App\Filament\Resources\AboutUsBlockResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutUsBlock extends EditRecord
{
    protected static string $resource = AboutUsBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['description'] = Helper::removeOuterPTag($data['description']);

        return $data;
    }
}
