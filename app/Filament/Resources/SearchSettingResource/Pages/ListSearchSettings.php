<?php

namespace App\Filament\Resources\SearchSettingResource\Pages;

use App\Filament\Resources\SearchSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSearchSettings extends ListRecords
{
    protected static string $resource = SearchSettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
