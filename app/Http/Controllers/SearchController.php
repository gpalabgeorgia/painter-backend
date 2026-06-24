<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SearchSetting;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Ищем настройки поиска в базе данных
        $settings = SearchSetting::first();

        // Если запись в базе еще не создана, подставляем дефолтные тексты
        if (!$settings) {
            $settings = new SearchSetting([
                'title' => 'Результаты поиска',
                'no_results_title' => 'Ничего не найдено',
                'no_results_text' => 'Попробуйте изменить запрос или поискать что-то другое (например, автора или стиль).'
            ]);
        }

        // Если поисковый запрос пустой, отдаем пустую коллекцию результатов
        if (empty($query)) {
            return view('search', [
                'query' => '',
                'results' => collect([]),
                'settings' => $settings
            ]);
        }

        // В будущем здесь будет реальный поиск по БД (например, по картинам)
        // $results = Artwork::where('title', 'like', "%{$query}%")->get();

        // А пока создаем пустую коллекцию, чтобы страница не падала
        $results = collect([]);

        return view('search', [
            'query' => $query,
            'results' => $results,
            'settings' => $settings
        ]);
    }
}
