<?php

namespace App\Filament\Resources\PortfolioItemResource\Pages;

use App\Filament\Resources\PortfolioItemResource;
use App\Helpers\Helper;
use DateTime;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditPortfolioItem extends EditRecord
{
    protected static string $resource = PortfolioItemResource::class;

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

    protected function afterSave(): void
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
