<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutomaticallyTranslatable;

class PastExhibitionHeader extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Поля для перевода
    protected array $translatableFields = ['section_title', 'section_description'];

    // Связь с таблицей переводов контента
    public function contentTranslations()
    {
        return $this->morphMany(ContentTranslation::class, 'translatable');
    }

    // Аксессор для формы Filament
    public function getTranslationsAttribute()
    {
        $locales = Language::where('code', '!=', 'es')->pluck('code')->toArray();
        $data = [];

        foreach ($locales as $locale) {
            foreach ($this->translatableFields as $field) {
                $translation = $this->contentTranslations()
                    ->where('lang_code', $locale)
                    ->where('field', $field)
                    ->first();

                $data[$locale][$field] = $translation ? $translation->value : null;
            }
        }

        return $data;
    }
}
