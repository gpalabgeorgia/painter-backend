<?php

namespace App\Filament\Resources\LogoSettingResource\Pages;

use App\Filament\Resources\LogoSettingResource;
use Filament\Resources\Pages\ListRecords;

class ListLogoSettings extends ListRecords
{
    protected static string $resource = LogoSettingResource::class;

    public function mount(): void
    {
        parent::mount();

        // Находим самую первую (и единственную) запись настроек
        $record = \App\Models\LogoSetting::first();

        if ($record) {
            // Если она есть, сразу редиректим на страницу её редактирования
            $this->redirect($this->getResource()::getUrl('edit', ['record' => $record->id]));
        }
    }

    protected function getActions(): array
    {
        // Убираем кнопку "New logo setting", так как запись может быть только одна
        return [];
    }
}
