<?php

namespace App\Observers;

use App\Models\Exhibition;

class ExhibitionObserver
{
    // Срабатывает при создании новой выставки И при её обновлении
    public function saved(Exhibition $exhibition): void
    {
        // Нас интересует логика только если текущая выставка активна
        if ($exhibition->is_active) {
            // Считаем, сколько сейчас ВСЕГО активных выставок
            $activeExhibitions = Exhibition::where('is_active', true)
                ->orderBy('created_at', 'desc') // Свежие вверху
                ->get();

            // Если активных стало больше 3
            if ($activeExhibitions->count() > 3) {
                // Берем все выставки, начиная с 4-й (самые старые)
                $exhibitionsToDeactivate = $activeExhibitions->skip(3);

                foreach ($exhibitionsToDeactivate as $oldExhibition) {
                    // Отключаем их без вызова событий, чтобы не уйти в бесконечный цикл
                    $oldExhibition->timestamps = false;
                    $oldExhibition->updateQuietly(['is_active' => false]);
                }
            }
        }
    }
}
