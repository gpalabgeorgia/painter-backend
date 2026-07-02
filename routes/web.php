<?php

use App\Http\Controllers\Front\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Models\ExhibitionHeader;
use Illuminate\Http\Request;
use App\Http\Controllers\Front\SubscribeController;
use App\Http\Controllers\Front\AboutController;
use App\Http\Controllers\Front\ArtworksPageController;
use App\Http\Controllers\Front\ExhibitionController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\AuthController;
use App\Http\Controllers\Front\ProfileController;


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

// Поиск
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Восстановление пароля админа
Route::get('/password-reset/{token}', function ($token) {
    // Сюда пользователь попадет, если кликнет по ссылке из письма.
    // Пока просто перенаправляем его на главную страницу админки, где он сможет войти
    return redirect()->to('/admin/login?token=' . $token);
})->name('password.reset');

// Редактирование Названий выствок
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

// Подписчики
Route::post('/subscribe', [SubscribeController::class, 'store'])->name('subscribe.store');

// Страница работ
Route::get('/artworks', [ArtworksPageController::class, 'index'])->name('artworks');

// Страница выставок
Route::get('/exhibitions', [ExhibitionController::class, 'index']);

// Контакты
Route::get('/contact', [HomeController::class, 'contacts'])->name('contact');
Route::post('/contact', [HomeController::class, 'storeContact'])->name('contact.store');

// Магазин
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Маршруты для гостей (доступны, если клиент не авторизован)
Route::middleware('guest:customer')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Выход из аккаунта (доступен только авторизованным клиентам)
Route::middleware('auth:customer')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Роут для перехода по ссылке из письма
Route::get('/activate/{token}', [AuthController::class, 'activate']);

Route::middleware('auth:customer')->group(function () {
    // Страница профиля
    Route::get('/account', [ProfileController::class, 'index'])->name('account');

    // Обработчики форм
    Route::post('/account/update-info', [ProfileController::class, 'updateInfo'])->name('account.update_info');
    Route::post('/account/update-password', [ProfileController::class, 'updatePassword'])->name('account.update_password');
});
