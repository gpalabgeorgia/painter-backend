<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Models\ExhibitionHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Front\SubscribeController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ArtworksPageController;
use App\Http\Controllers\Front\ExhibitionController;
use App\Http\Controllers\Front\HomeController;

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/
// Главная страница сайта
Route::get('/', [HomeController::class, 'index'])->name('home');

// Чистый, читаемый роут для страницы About
Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/password-reset/{token}', function ($token) {
    // Сюда пользователь попадет, если кликнет по ссылке из письма.
    // Пока просто перенаправляем его на главную страницу админки, где он сможет войти
    return redirect()->to('/admin/login?token=' . $token);
})->name('password.reset');

Route::post('/admin/exhibitions/save-headers', function (Request $request) {
    $header = ExhibitionHeader::first() ?? new ExhibitionHeader();
    $header->fill([
        'main_title' => $request->input('main_title'),
        'subtitle' => $request->input('subtitle'),
    ])->save();
    return redirect()->back()->with('filament.notifications', [
        [
            'title' => 'Заголовки секции успешно обновлены!',
            'type' => 'success',
        ],
    ]);
})->name('filament.exhibitions.save-headers')->middleware(['web', 'auth']);

Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');
Route::get('/artworks', [ArtworksPageController::class, 'index'])->name('artworks');
Route::get('/exhibitions', [ExhibitionController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contacts'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');
