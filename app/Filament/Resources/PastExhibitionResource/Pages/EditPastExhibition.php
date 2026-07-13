<?php

namespace App\Filament\Resources\PastExhibitionResource\Pages;

use App\Filament\Resources\PastExhibitionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPastExhibition extends EditRecord
{
    protected static string $resource = PastExhibitionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make()->before(function () {
                $this->record->contentTranslations()->delete();
            }),
        ];
    }

    // Заполняем вкладки переводов при открытии страницы
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['translations'] = $this->record->translations;
        return $data;
    }

    // Отрезаем переводы из основного запроса, чтобы Laravel не искал такую колонку в базе
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Извлекаем переводы в свойство класса, чтобы использовать их в beforeSave
        $this->customTranslations = $data['translations'] ?? [];

        // Удаляем ключ из массива данных, который пойдет в таблицу past_exhibitions
        unset($data['translations']);

        return $data;
    }

    // Сохраняем переводы после успешного обновления основной модели
    protected function beforeSave(): void
    {
        // Берём переводы, которые мы отфильтровали шагом ранее
        $translations = $this->customTranslations ?? [];

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
