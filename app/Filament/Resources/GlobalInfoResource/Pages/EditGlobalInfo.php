<?php

namespace App\Filament\Resources\GlobalInfoResource\Pages;

use App\Filament\Resources\GlobalInfoResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGlobalInfo extends EditRecord
{
    protected static string $resource = GlobalInfoResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['page_description'] = Helper::removeOuterPTag($data['page_description']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
