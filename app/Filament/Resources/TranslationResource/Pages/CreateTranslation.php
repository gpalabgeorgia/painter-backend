<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $key = $data['key'];
        $firstRecord = null;

        // Перебираем все поля формы
        foreach ($data as $inputName => $value) {
            if (str_starts_with($inputName, 'lang_')) {
                $langCode = str_replace('lang_', '', $inputName);

                // Создаем строку для каждого языка
                $record = Translation::create([
                    'key' => $key,
                    'lang_code' => $langCode,
                    'value' => $value,
                ]);

                if (!$firstRecord) {
                    $firstRecord = $record; // Filament нужен один корневой объект для возврата
                }
            }
        }

        return $firstRecord;
    }
}
