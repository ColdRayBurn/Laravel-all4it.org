<?php

namespace App\Filament\Resources\PortfolioItemResource\Pages;

use App\Filament\Resources\PortfolioItemResource;
use DateTime;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;


class CreatePortfolioItem extends CreateRecord
{
    protected static string $resource = PortfolioItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['description'] = Helper::removeOuterPTag($data['description']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if (!$this->record) {
            return;
        }
        $logo = $this->record->logotype;
        if (!$logo) {
            return;
        }

        $filePath = Storage::disk('public')->path($logo);
        Helper::makeImageWhite($filePath);
    }
}
