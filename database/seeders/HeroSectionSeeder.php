<?php

namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (HeroSection::count() === 0) {
            HeroSection::create([
                'is_active' => true,
                'left_title' => 'John Alwin',
                'left_text_1' => 'Первая строка описания художника.',
                'left_text_2' => 'Вторая строка описания художника.',
                'center_image' => null, // Загрузит сам через админку
                'right_small_text' => 'Маленький текст справа',
            ]);
        }
    }
}
