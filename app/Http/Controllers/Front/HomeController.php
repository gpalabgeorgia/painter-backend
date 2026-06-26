<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ArtworkHeader;
use Illuminate\Http\Request;
use App\Models\HeroSection;
use App\Models\EnergySection;
use App\Models\VideoSection;
use App\Models\Exhibition;
use App\Models\ExhibitionHeader;
use App\Models\TestimonialSection;
use App\Models\PromoSection;
use App\Models\Artwork;

class HomeController extends Controller
{
    public function index()
    {
        // Вытаскиваем настройки Hero-секции из базы данных
        $hero = HeroSection::first();
        $energy = EnergySection::first();
        $videoData = VideoSection::where('is_active', true)->first();
        // Берем активные выставки, максимум 3 штуки, свежие — первыми
        $exhibitions = Exhibition::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $exhibitionHeader = ExhibitionHeader::first();
        $testimonial = TestimonialSection::first();
        $promo = PromoSection::first();
        $artworks = Artwork::latest()->take(4)->get();
        $artworkHeader = ArtworkHeader::first();

        // Отдает файл resources/views/pages/home.blade.php и прокидывает туда данные секции
        return view('pages.home', compact('hero', 'energy', 'videoData', 'exhibitions', 'exhibitionHeader', 'testimonial', 'promo', 'artworks', 'artworkHeader'));
    }
}
