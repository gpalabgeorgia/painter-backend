<?php

namespace App\Filament\Resources\PastExhibitionResource\Pages;

use App\Filament\Resources\PastExhibitionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPastExhibitions extends ListRecords
{
    protected static string $resource = PastExhibitionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
