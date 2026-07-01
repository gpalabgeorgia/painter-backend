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
use App\Models\NavigationItem;
use App\Models\HeaderContact;
use App\Models\LogoSetting;
use App\Models\ContactMessage;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Твой родной рабочий код для главной страницы
        $hero = HeroSection::first();
        $energy = EnergySection::first();
        $videoData = VideoSection::where('is_active', true)->first();
        $exhibitions = Exhibition::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        $exhibitionHeader = ExhibitionHeader::first();
        $testimonial = TestimonialSection::first();
        $promo = PromoSection::first();
        $artworkHeader = ArtworkHeader::first();
        $subscribeSection = \App\Models\SubscribeSection::first();

        $footerMenus = NavigationItem::all();
        // Для главной оставляем как было, чтобы ничего не поломать в хедере
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();

        // Вытаскиваем 4 последние активные картины из базы данных
        $featuredProducts = Product::where('is_active', true)
            ->latest() // Сортируем по дате добавления: сначала новые
            ->take(4)  // Берем ровно 4 штуки
            ->get();

        return view('pages.home', compact('hero', 'energy', 'videoData', 'exhibitions', 'exhibitionHeader', 'testimonial', 'promo', 'artworkHeader', 'subscribeSection', 'footerMenus', 'contactData', 'logos', 'featuredProducts'));
    }

    /**
     * МЕТОД ДЛЯ СТРАНИЦЫ КОНТАКТОВ
     */
    public function contacts()
    {
        // Забираем вообще ВСЕ активные контакты и превращаем в удобную коллекцию с ключами по типу
        $contacts = HeaderContact::where('is_active', true)->get()->keyBy('type');

        // Нужные для хедера/футера штуки тоже вытащим, если они там используются
        $footerMenus = NavigationItem::all();
        $logos = LogoSetting::first();

        // Отдаем будущую страницу контактов
        return view('pages.contact', compact('contacts', 'footerMenus', 'logos'));
    }

    /**
     * МЕТОД ДЛЯ СОХРАНЕНИЯ СООБЩЕНИЙ С ФОРМЫ
     */
    public function storeContact(Request $request)
    {
        // Валидируем входящие поля
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
        ]);

        // Теперь красиво вызываем черезuse
        ContactMessage::create($validated);

        // Возвращаем назад с сообщением об успехе
        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }
}
