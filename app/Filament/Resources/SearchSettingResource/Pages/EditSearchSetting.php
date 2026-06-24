<?php

namespace App\Filament\Resources\SearchSettingResource\Pages;

use App\Filament\Resources\SearchSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSearchSetting extends EditRecord
{
    protected static string $resource = SearchSettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
