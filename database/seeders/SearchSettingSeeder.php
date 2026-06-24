<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SearchSetting;

class SearchSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (SearchSetting::count() === 0) {
            SearchSetting::create([
                'title' => 'Результаты поиска',
                'no_results_title' => 'Ничего не найдено',
                'no_results_text' => 'Попробуйте изменить запрос или поискать что-то другое (например, автора или стиль).'
            ]);
        }
    }
}
