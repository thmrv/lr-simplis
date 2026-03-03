<?php

namespace App\Filament\Resources\LocaleStrings\Pages;

use App\Filament\Resources\LocaleStrings\LocaleStringResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLocaleStrings extends ManageRecords
{
    protected static string $resource = LocaleStringResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
