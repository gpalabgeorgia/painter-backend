<?php

namespace App\Http\Controllers\Front;

use App\Models\Translation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    // 1. Роут для клика по иконке в хедере
    public function switch($locale)
    {
        if (\App\Models\Language::where('code', $locale)->where('is_active', true)->exists()) {
            Session::put('locale', $locale);
        }
        return redirect()->back();
    }

    // 2. Статичный метод, который мы будем вызывать прямо в Blade-шаблонах
    public static function trans($key)
    {
        $locale = Session::get('locale', config('app.locale', 'es'));
        \Illuminate\Support\Facades\App::setLocale($locale);

        $translations = Cache::remember("site_translations_{$locale}", 86400, function () use ($locale) {
            // Загружаем все ключи в нижнем регистре, чтобы не зависеть от капса
            return Translation::where('lang_code', $locale)
                ->get()
                ->mapWithKeys(function ($item) {
                    return [mb_strtolower($item->key) => $item->value];
                })
                ->toArray();
        });

        // Переводим искомую строку тоже в нижний регистр для проверки
        $lookupKey = mb_strtolower($key);

        return !empty($translations[$lookupKey]) ? $translations[$lookupKey] : $key;
    }
}
