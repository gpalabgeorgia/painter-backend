<?php

namespace App\Filament\Resources\SubscribeSectionResource\Pages;

use App\Filament\Resources\SubscribeSectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubscribeSections extends ListRecords
{
    protected static string $resource = SubscribeSectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
