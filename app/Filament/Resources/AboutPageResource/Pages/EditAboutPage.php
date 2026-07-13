<?php

namespace App\Filament\Resources\AboutPageResource\Pages;

use App\Filament\Resources\AboutPageResource;
use Filament\Resources\Pages\EditRecord;

class EditAboutPage extends EditRecord
{
    protected static string $resource = AboutPageResource::class;

    // Фикс ошибки роута: Если ID записи не передан в URL, принудительно открываем запись с ID 1
    public function mount($record = null): void
    {
        if ($record === null) {
            $record = 1;
        }

        parent::mount($record);
    }

    // Перед заполнением формы: берем переводы из модели и пушим их во вложенные табы Filament
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['translations'] = $this->record->translations;
        return $data;
    }

    // После сохранения страницы: берем переводы из формы и пишем напрямую в базу
    protected function afterSave(): void
    {
        // Безопасно получаем чистые данные формы Filament v2
        $data = $this->form->getRawState();
        $translations = $data['translations'] ?? [];

        foreach ($translations as $locale => $fields) {
            if (!is_array($fields)) continue;

            foreach ($fields as $field => $value) {
                if ($value !== null && $value !== '') {
                    $this->record->contentTranslations()->updateOrCreate(
                        ['lang_code' => $locale, 'field' => $field],
                        ['value' => $value]
                    );
                } else {
                    $this->record->contentTranslations()
                        ->where('lang_code', $locale)
                        ->where('field', $field)
                        ->delete();
                }
            }
        }
    }
}
