<?php

namespace App\Filament\Resources\AboutUsBlockResource\Pages;

use App\Filament\Resources\AboutUsBlockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutUsBlocks extends ListRecords
{
    protected static string $resource = AboutUsBlockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
