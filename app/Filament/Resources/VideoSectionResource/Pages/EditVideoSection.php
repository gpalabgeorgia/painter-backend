<?php

namespace App\Filament\Resources\VideoSectionResource\Pages;

use App\Filament\Resources\VideoSectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoSection extends EditRecord
{
    protected static string $resource = VideoSectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
