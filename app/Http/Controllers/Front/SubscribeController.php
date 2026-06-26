<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.required' => 'Пожалуйста, введите ваш email.',
            'email.email' => 'Введите корректный адрес электронной почты.',
            'email.unique' => 'Этот email уже подписан на рассылку!',
        ]);

        Subscriber::create(['email' => $request->email]);

        return back()->with('subscribe_success', 'Вы успешно подписались на рассылку!');
    }
}
