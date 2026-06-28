<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutPages extends ListRecords
{
    protected static string $resource = AboutPageResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = \App\Models\AboutPage::first();

        // Редиректим НА РЕДАКТИРОВАНИЕ только если запись реально существует!
        if ($record !== null) {
            $this->redirect($this->getResource()::getUrl('edit', ['record' => $record->id]));
        }
    }

    protected function getActions(): array
    {
        // Кнопка создания покажется ТОЛЬКО если в базе пусто
        return \App\Models\AboutPage::exists() ? [] : [
            Actions\CreateAction::make()->label('Создать страницу'),
        ];
    }
}
