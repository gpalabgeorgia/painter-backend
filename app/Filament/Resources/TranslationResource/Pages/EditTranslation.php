<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use Filament\Resources\Pages\EditRecord;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        foreach ($data as $inputName => $value) {
            if (str_starts_with($inputName, 'lang_')) {
                $langCode = str_replace('lang_', '', $inputName);

                // Обновляем или создаем перевод, если его забыли заполнить раньше
                Translation::updateOrCreate(
                    ['key' => $record->key, 'lang_code' => $langCode],
                    ['value' => $value]
                );
            }
        }

        return $record;
    }
}
