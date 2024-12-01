<?php

namespace App\Filament\Resources\GlobalInfoResource\Pages;

use App\Filament\Resources\GlobalInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGlobalInfos extends ListRecords
{
    protected static string $resource = GlobalInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
