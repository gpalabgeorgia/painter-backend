<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutPage extends CreateRecord
{
    protected static string $resource = AboutPageResource::class;

    // После создания принудительно редиректим на редактирование ЭТОЙ ЖЕ записи
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
