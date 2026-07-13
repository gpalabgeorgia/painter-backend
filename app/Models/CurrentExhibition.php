<?php

namespace App\Models;

use App\Traits\AutomaticallyTranslatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentExhibition extends Model
{
    use HasFactory;

    protected $guarded = [];

    use AutomaticallyTranslatable;

    // Список полей, которые подлежат переводу
    protected array $translatableFields = ['page_title', 'subtitle', 'title', 'description'];

    // Связь с таблицей переводов контента
    public function contentTranslations()
    {
        return $this->morphMany(ContentTranslation::class, 'translatable');
    }

    // Аксессор, который собирает все переводы для Filament формы
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
