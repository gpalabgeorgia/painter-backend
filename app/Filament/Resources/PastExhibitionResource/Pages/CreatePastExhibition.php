<?php

namespace App\Filament\Resources\PastExhibitionResource\Pages;

use App\Filament\Resources\PastExhibitionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePastExhibition extends CreateRecord
{
    protected static string $resource = PastExhibitionResource::class;

    protected function afterCreate(): void
    {
        $translations = $this->data['translations'] ?? [];

        foreach ($translations as $locale => $fields) {
            if (!is_array($fields)) continue;

            foreach ($fields as $field => $value) {
                if ($value !== null && $value !== '') {
                    $this->record->contentTranslations()->create([
                        'lang_code' => $locale,
                        'field' => $field,
                        'value' => $value,
                    ]);
                }
            }
        }
    }
}
