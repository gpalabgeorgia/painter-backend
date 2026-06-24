<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\NavigationItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); // <-- 2. ДОБАВИТЬ ЭТУ СТРОКУ

        // Передаем пункты меню во вьюху хедера при каждом её рендере
        View::composer('partials.header', function ($view) {
            $menuItems = NavigationItem::where('is_active', true)
                ->orderBy('sort', 'asc')
                ->get();

            $view->with('menuItems', $menuItems);
        });
    }
}
