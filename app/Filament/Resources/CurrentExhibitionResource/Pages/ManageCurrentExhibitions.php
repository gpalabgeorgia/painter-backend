<?php

namespace App\Filament\Resources\CurrentExhibitionResource\Pages;

use App\Filament\Resources\CurrentExhibitionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageCurrentExhibitions extends ManageRecords
{
    protected static string $resource = CurrentExhibitionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
