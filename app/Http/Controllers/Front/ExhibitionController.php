<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CurrentExhibition;
use App\Models\PastExhibition;
use App\Models\PastExhibitionHeader;
use App\Models\NavigationItem;
use App\Models\HeaderContact;
use App\Models\LogoSetting;
use App\Models\SubscribeSection;
use App\Models\Exhibition;

class ExhibitionController extends Controller
{
    public function index()
    {
        $footerMenus = NavigationItem::all();
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();
        $subscribeSection = SubscribeSection::first();
        // Внутри метода — только чистый, аккуратный код
        $currentExhibition = CurrentExhibition::where('is_active', true)->first();

        $pastHeader = PastExhibitionHeader::first();
        $pastExhibitions = PastExhibition::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
        // 1. Забираем активные предстоящие выставки по порядку сортировки
        $upcomingExhibitions = Exhibition::where('is_active', true)
            ->orderBy('id', 'asc')
            ->get();

        return view('pages.exhibitions', compact('currentExhibition', 'pastHeader', 'pastExhibitions', 'footerMenus', 'contactData', 'logos', 'subscribeSection', 'upcomingExhibitions'));
    }
}
