<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use App\Models\Language;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $key = $data['key'];
        $languages = Language::where('is_active', true)->get();
        $mainRecord = null;

        foreach ($languages as $index => $lang) {
            // Для главного языка значением является сам ключ (или можно оставить пустым, если логика другая)
            if ($index === 0) {
                $value = $key;
                $langCode = $lang->code;
            } else {
                $value = $data["lang_{$lang->code}"] ?? null;
                $langCode = $lang->code;
            }

            if ($value !== null && $value !== '') {
                // Используем updateOrCreate, чтобы если ключ уже частично есть в базе (для en/ru),
                // для нового языка (ge) он просто добавился без ошибок уникальности!
                $record = Translation::updateOrCreate(
                    ['key' => $key, 'lang_code' => $langCode],
                    ['value' => $value]
                );

                if (!$mainRecord) {
                    $mainRecord = $record;
                }
            }
        }

        return $mainRecord ?? new Translation();
    }
}
