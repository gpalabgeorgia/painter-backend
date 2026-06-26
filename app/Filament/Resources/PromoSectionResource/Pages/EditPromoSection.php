<?php

namespace App\Filament\Resources\PromoSectionResource\Pages;

use App\Filament\Resources\PromoSectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPromoSection extends EditRecord
{
    protected static string $resource = PromoSectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
