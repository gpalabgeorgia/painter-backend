<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Читаем язык из сессии (точно так же, как в твоем контроллере)
        $locale = Session::get('locale', config('app.locale', 'es'));

        // Устанавливаем его глобально для ВСЕГО приложения ДО загрузки моделей и шаблонов
        App::setLocale($locale);

        return $next($request);
    }
}
