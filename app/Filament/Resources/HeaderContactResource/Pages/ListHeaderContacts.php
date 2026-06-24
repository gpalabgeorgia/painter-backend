<?php

namespace App\Filament\Resources\HeaderContactResource\Pages;

use App\Filament\Resources\HeaderContactResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHeaderContacts extends ListRecords
{
    protected static string $resource = HeaderContactResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
