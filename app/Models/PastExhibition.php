<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutomaticallyTranslatable;

class PastExhibition extends Model
{
    use HasFactory;

    use AutomaticallyTranslatable;

    protected $guarded = [];

    // Поля, подлежащие переводу
    protected array $translatableFields = ['title', 'description'];

    // Связь с таблицей переводов контента
    public function contentTranslations()
    {
        return $this->morphMany(ContentTranslation::class, 'translatable');
    }

    // Аксессор, собирающий существующие переводы для Filament формы
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
