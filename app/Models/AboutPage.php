<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\AutomaticallyTranslatable;
use App\Models\Language;

class AboutPage extends Model
{
    use HasFactory;
    use AutomaticallyTranslatable;

    protected $fillable = [
        's1_title',
        's1_image',
        's1_subtitle',
        's1_text',

        // Поля Секции 2
        's2_image',
        's2_quote',
        's2_signature',
        's2_name',

        // Поля Секции 3
        's3_title',
        's3_logos',
        's3_text',
    ];

    protected $casts = [
        's3_logos' => 'array', // Критически важно для мультизагрузки
    ];

    // Список текстовых полей этой модели, которые нужно переводить
    protected array $translatableFields = [
        's1_title', 's1_subtitle', 's1_text',
        's2_quote', 's2_name',
        's3_title', 's3_text'
    ];

    // Динамически загружает переводы во вкладки админки Filament для всех языков, кроме основного (es)
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
