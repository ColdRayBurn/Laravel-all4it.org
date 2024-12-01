<?php

namespace App\Filament\Resources\HomepageInfoResource\Pages;

use App\Filament\Resources\HomepageInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomepageInfos extends ListRecords
{
    protected static string $resource = HomepageInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
