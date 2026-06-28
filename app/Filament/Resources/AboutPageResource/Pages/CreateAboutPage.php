<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAboutPage extends CreateRecord
{
    protected static string $resource = AboutPageResource::class;

    // На всякий случай: если запись создана, сразу кидаем на её редактирование
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record->id]);
    }
}
