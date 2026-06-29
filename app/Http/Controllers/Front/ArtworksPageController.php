<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NavigationItem;
use App\Models\HeaderContact;
use App\Models\LogoSetting;
use App\Models\SubscribeSection;

class ArtworksPageController extends Controller
{
    public function index()
    {
        $footerMenus = NavigationItem::all();
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();
        $subscribeSection = SubscribeSection::first();
        $artworksData = \App\Models\ArtworksPage::first();

        // Забираем элементы сетки по 6 штук на страницу
        $artworkItems = \App\Models\ArtworkItem::paginate(6);

        return view('pages.artworks', compact(
            'footerMenus',
            'contactData',
            'logos',
            'subscribeSection',
            'artworksData',
            'artworkItems' // <--- Передали коллекцию с пагинацией
        ));
    }
}
