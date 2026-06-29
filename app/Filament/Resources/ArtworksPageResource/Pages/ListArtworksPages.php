<?php

namespace App\Filament\Resources\ArtworksPageResource\Pages;

use App\Filament\Resources\ArtworksPageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtworksPages extends ListRecords
{
    protected static string $resource = ArtworksPageResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
