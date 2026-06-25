<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use App\Models\EnergySection;
use App\Models\VideoSection;

class HomeController extends Controller
{
    public function index()
    {
        // Вытаскиваем настройки Hero-секции из базы данных
        $hero = HeroSection::first();
        $energy = EnergySection::first();
        $videoData = VideoSection::where('is_active', true)->first();

        // Отдает файл resources/views/pages/home.blade.php и прокидывает туда данные секции
        return view('pages.home', compact('hero', 'energy', 'videoData'));
    }
}
