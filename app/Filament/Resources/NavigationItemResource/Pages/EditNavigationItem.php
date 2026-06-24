<?php

namespace App\Filament\Resources\NavigationItemResource\Pages;

use App\Filament\Resources\NavigationItemResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNavigationItem extends EditRecord
{
    protected static string $resource = NavigationItemResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
