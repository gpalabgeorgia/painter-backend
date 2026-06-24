<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\SearchController;

/*
|--------------------------------------------------------------------------
| Front Routes
|--------------------------------------------------------------------------
|
*/
// Главная страница сайта
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::get('/password-reset/{token}', function ($token) {
    // Сюда пользователь попадет, если кликнет по ссылке из письма.
    // Пока просто перенаправляем его на главную страницу админки, где он сможет войти
    return redirect()->to('/admin/login?token=' . $token);
})->name('password.reset');
