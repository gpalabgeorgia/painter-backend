<?php

namespace App\Filament\Resources\ArtworksPageResource\Pages;

use App\Filament\Resources\ArtworksPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateArtworksPage extends CreateRecord
{
    protected static string $resource = ArtworksPageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
