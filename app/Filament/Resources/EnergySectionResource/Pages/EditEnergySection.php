<?php

namespace App\Filament\Resources\EnergySectionResource\Pages;

use App\Filament\Resources\EnergySectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnergySection extends EditRecord
{
    protected static string $resource = EnergySectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
