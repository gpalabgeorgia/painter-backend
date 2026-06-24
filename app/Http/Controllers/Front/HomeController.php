<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HeroSection;

class HomeController extends Controller
{
    public function index()
    {
        // Вытаскиваем настройки Hero-секции из базы данных
        $hero = HeroSection::first();

        // Отдает файл resources/views/pages/home.blade.php и прокидывает туда данные секции
        return view('pages.home', compact('hero'));
    }
}
