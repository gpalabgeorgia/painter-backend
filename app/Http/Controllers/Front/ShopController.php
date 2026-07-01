<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\HeaderContact;
use App\Models\LogoSetting;
use App\Models\NavigationItem;
use App\Models\Product;
use App\Models\SubscribeSection;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Вывод страницы магазина со всеми активными картинами
     */
    public function index()
    {
        // Берем только те картины, у которых стоит галочка "Отображать в магазине"
        $products = Product::where('is_active', true)
            ->latest() // Свежие картины будут первыми в списке
            ->get();
        $footerMenus = NavigationItem::all();
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();
        $subscribeSection = SubscribeSection::first();

        return view('pages.shop', compact('products', 'footerMenus', 'contactData', 'logos', 'subscribeSection'));
    }
}
