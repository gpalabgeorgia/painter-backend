<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\NavigationItem;
use App\Models\HeaderContact;
use Filament\Facades\Filament;
use App\Models\Notification;
use Illuminate\Support\HtmlString;

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
        // Универсальный метод для старых версий Laravel
        \Illuminate\Pagination\Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        // Передаем пункты меню во вьюху хедера при каждом её рендере
        View::composer('partials.header', function ($view) {
            // Загружаем пункты меню
            $menuItems = NavigationItem::where('is_active', true)
                ->orderBy('sort', 'asc')
                ->get();

            // Загружаем активные контакты и соцсети
            $headerContacts = HeaderContact::where('is_active', true)->get();

            $view->with([
                'menuItems' => $menuItems,
                'headerContacts' => $headerContacts,
            ]);
        });

        // Регистрируем стили и поведение для админки Filament
        Filament::serving(function () {
            // Считаем непрочитанные сообщения от клиентов
            $unreadCount = Notification::where('sender', 'customer')
                ->where('is_read', false)
                ->count();

            if ($unreadCount > 0) {
                Filament::registerRenderHook(
                    'body.end',
                    fn (): string => new HtmlString("
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Ищем кнопку-аватарку в верхнем правом углу панели Filament
                            const avatarButton = document.querySelector('.filament-user-menu button');

                            if (avatarButton) {
                                // Делаем позиционирование кнопки относительным, чтобы точка не улетала
                                avatarButton.style.position = 'relative';

                                // Создаем красный бейдж счетчика
                                const badge = document.createElement('span');
                                badge.innerText = '{$unreadCount}';
                                badge.style.position = 'absolute';
                                badge.style.top = '-2px';
                                badge.style.right = '-2px';
                                badge.style.background = '#ef4444'; // красный цвет Tailwind
                                badge.style.color = 'white';
                                badge.style.borderRadius = '9999px';
                                badge.style.width = '18px';
                                badge.style.height = '18px';
                                badge.style.fontSize = '11px';
                                badge.style.fontWeight = 'bold';
                                badge.style.display = 'flex';
                                badge.style.alignItems = 'center';
                                badge.style.justifyContent = 'center';
                                badge.style.border = '2px solid #fff';
                                badge.style.boxShadow = '0 2px 4px rgba(0,0,0,0.15)';

                                avatarButton.appendChild(badge);
                            }
                        });
                    </script>
                "),
                );
            }
        });

    }
}
