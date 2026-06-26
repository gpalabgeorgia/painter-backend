<?php

namespace App\Filament\Resources\ArtworkHeaderResource\Pages;

use App\Filament\Resources\ArtworkHeaderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtworkHeader extends EditRecord
{
    protected static string $resource = ArtworkHeaderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
