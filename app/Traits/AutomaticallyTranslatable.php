<?php

namespace App\Traits;

use App\Models\ContentTranslation;
use Illuminate\Support\Facades\App;

trait AutomaticallyTranslatable
{
    // Связь: каждая модель теперь знает, что у неё могут быть переводы
    public function contentTranslations()
    {
        return $this->morphMany(ContentTranslation::class, 'translatable');
    }

    // Перехватываем обращение к любому полю модели (например, $exhibition->s1_title)
    public function getAttribute($key)
    {
        // Получаем оригинальное значение поля из родной таблицы
        $value = parent::getAttribute($key);

        // Получаем текущий язык сайта (например, 'en')
        $currentLocale = App::getLocale();

        // Получаем дефолтный язык (например, 'es'). Замени 'es', если дефолтный другой
        $defaultLocale = 'es';

        // Если сейчас выбран дефолтный язык, или мы запрашиваем системное поле/связь, отдаем оригинал
        if ($currentLocale === $defaultLocale || in_array($key, ['id', 'created_at', 'updated_at']) || method_exists($this, $key)) {
            return $value;
        }

        // Если это обычное текстовое поле и выбран не дефолтный язык (например, 'en')
        // Ищем, есть ли для этого поля сохраненный перевод в нашей общей таблице
        $translation = $this->contentTranslations
            ->where('field', $key)
            ->where('lang_code', $currentLocale)
            ->first();

        // Если перевод найден — отдаем его, если нет — возвращаем оригинальный текст (испанский)
        return $translation ? $translation->value : $value;
    }
}
