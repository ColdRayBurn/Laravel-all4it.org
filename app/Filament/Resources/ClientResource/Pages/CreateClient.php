<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Helpers\Helper;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function afterCreate(): void
    {
        if (!$this->record) {
            return;
        }
        $logo = $this->record->image;
        if (!$logo) {
            return;
        }

        $filePath = Storage::disk('public')->path($logo);
        Helper::makeImageWhite($filePath);
    }
}
