<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Resources\Pages\EditRecord;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    // Метод mount в Filament v2 принимает параметр $record (ID записи)
    // Если мы зашли по роуту '/', то $record будет пустой. Заполняем его вручную!
    public function mount($record = null): void
    {
        // Ищем первую запись или создаем дефолтную, если в базе пусто
        $page = \App\Models\AboutPage::firstOrCreate(
            ['id' => 1],
            ['s1_title' => 'Биография']
        );

        // Принудительно передаем ID записи в родительский метод Filament
        parent::mount($page->id);
    }

    protected function getRedirectUrl(): string
    {
        // После сохранения остаемся здесь же
        return $this->getResource()::getUrl('index');
    }
}
