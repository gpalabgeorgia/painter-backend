<?php

namespace App\Filament\Resources\VideoSectionResource\Pages;

use App\Filament\Resources\VideoSectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideoSections extends ListRecords
{
    protected static string $resource = VideoSectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
