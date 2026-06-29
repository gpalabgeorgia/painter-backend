<?php

namespace App\Filament\Resources\ArtworkItemResource\Pages;

use App\Filament\Resources\ArtworkItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworkItems extends ListRecords
{
    protected static string $resource = ArtworkItemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
