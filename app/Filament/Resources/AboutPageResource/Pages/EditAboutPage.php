<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\AboutPage;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    // Этот метод проверяет наличие записи при загрузке страницы
    public function mount($record = null): void
    {
        // Находим или автоматически создаем запись с ID = 1, если в базе пусто
        $page = AboutPage::firstOrCreate(
            ['id' => 1],
            [
                's1_title' => 'About',
                's3_title' => 'Awards'
            ]
        );

        // Передаем ID записи в Filament для открытия формы редактирования
        parent::mount($page->id);
    }

    protected function getRedirectUrl(): string
    {
        // После сохранения оставляем админа на этой же странице редактирования
        return $this->getResource()::getUrl('index');
    }
}
