<?php

use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\LanguageController;
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
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CustomerAddressController;

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/

// Главная страница сайта
Route::get('/', [HomeController::class, 'index'])->name('home');

// Страница About
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Поиск
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Восстановление пароля админа
Route::get('/password-reset/{token}', function ($token) {
    return redirect()->to('/admin/login?token=' . $token);
})->name('password.reset');

// Редактирование Названий выставок в админке
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

// Роут для перехода по ссылке из письма
Route::get('/activate/{token}', [AuthController::class, 'activate']);

// AJAX добавление в корзину (контроллер сам разрулит гостя)
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');


// Маршруты для гостей (доступны, если клиент НЕ авторизован)
Route::middleware('guest:customer')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


// Маршруты, которые ТРЕБУЮТ обязательной авторизации покупателя
Route::middleware('auth:customer')->group(function () {
    // Выход из аккаунта
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Страница профиля
    Route::get('/account', [ProfileController::class, 'index'])->name('account');

    // Обработчики форм профиля
    Route::post('/account/update-info', [ProfileController::class, 'updateInfo'])->name('account.update_info');
    Route::post('/account/update-password', [ProfileController::class, 'updatePassword'])->name('account.update_password');

    // Адреса доставки
    Route::post('/account/addresses', [CustomerAddressController::class, 'store'])->name('account.addresses.store');
    Route::delete('/account/addresses/{id}', [CustomerAddressController::class, 'destroy'])->name('account.addresses.destroy');

    // Страница корзины
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Фоновое получение данных корзины
    Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');

    // AJAX операции с корзиной
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // Страница оформления заказа (Чекаут)
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout.index');

    // Создание заказа из чекаута (Теперь сессия пользователя железно не потеряется)
    Route::post('/checkout/store', [CartController::class, 'storeOrder'])->name('checkout.store');

    Route::get('/account/messages', [AuthController::class, 'messages'])->name('profile.notifications');
    Route::post('/account/messages/{id}/reply', [AuthController::class, 'reply'])->name('profile.notifications.reply');
    Route::delete('/account/messages/{id}', [AuthController::class, 'destroy'])->name('profile.notifications.destroy');
});
    Route::get('lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');;
