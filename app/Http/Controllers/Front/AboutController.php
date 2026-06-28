<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NavigationItem;
use App\Models\HeaderContact;
use App\Models\LogoSetting;
use App\Models\AboutPage;

class AboutController extends Controller
{
    public function index()
    {
        // Не забываем вытащить данные для шапки и футера, чтобы они не были пустыми!
        $footerMenus = NavigationItem::all();
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();
        // Забираем нашу единственную запись с секциями
        $aboutData = AboutPage::first();

        return view('pages.about', compact('footerMenus', 'contactData', 'logos', 'aboutData'));
    }
}
