<?php

namespace App\Filament\Resources\EnergySectionResource\Pages;

use App\Filament\Resources\EnergySectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnergySections extends ListRecords
{
    protected static string $resource = EnergySectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
