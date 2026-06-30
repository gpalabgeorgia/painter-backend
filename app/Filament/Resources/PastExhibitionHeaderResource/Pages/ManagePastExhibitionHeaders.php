<?php

namespace App\Filament\Resources\PastExhibitionHeaderResource\Pages;

use App\Filament\Resources\PastExhibitionHeaderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePastExhibitionHeaders extends ManageRecords
{
    protected static string $resource = PastExhibitionHeaderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
