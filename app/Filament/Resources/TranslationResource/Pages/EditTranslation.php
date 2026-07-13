<?php

namespace App\Filament\Resources\TranslationResource\Pages;

use App\Filament\Resources\TranslationResource;
use App\Models\Translation;
use App\Models\Language;
use Filament\Resources\Pages\EditRecord;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;

    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        $languages = Language::where('is_active', true)->get();

        foreach ($languages as $index => $lang) {
            if ($index === 0) continue; // Главный язык не редактируем, он залочен

            $value = $data["lang_{$lang->code}"] ?? null;

            if ($value !== null && $value !== '') {
                Translation::updateOrCreate(
                    ['key' => $record->key, 'lang_code' => $lang->code],
                    ['value' => $value]
                );
            } else {
                Translation::where('key', $record->key)
                    ->where('lang_code', $lang->code)
                    ->delete();
            }
        }

        return $record;
    }
}
