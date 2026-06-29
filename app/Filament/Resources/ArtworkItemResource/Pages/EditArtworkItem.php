<?php

namespace App\Filament\Resources\ArtworkItemResource\Pages;

use App\Filament\Resources\ArtworkItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtworkItem extends EditRecord
{
    protected static string $resource = ArtworkItemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
