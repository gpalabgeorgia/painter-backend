<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogoSetting;
use App\Models\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Отображение личного кабинета
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        // Переменные для корректной работы хедера и футера
        $logos = LogoSetting::first();
        $footerMenus = NavigationItem::all();

        return view('pages.profile.index', compact('customer', 'logos', 'footerMenus'));
    }

    // Обновление личных данных, адреса и аватарки
    public function updateInfo(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->only(['name', 'last_name', 'email', 'phone', 'country', 'region', 'city', 'zip_code', 'address']);

        // Работа с аватаркой
        if ($request->hasFile('avatar')) {
            if ($customer->avatar) {
                Storage::disk('public')->delete($customer->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $customer->update($data);

        return back()->with('success', 'Личные данные и адрес доставки успешно сохранены.');
    }

    // Логика изменения пароля
    public function updatePassword(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'Новые пароли не совпадают.',
            'new_password.min' => 'Новый пароль должен быть не менее 6 символов.',
        ]);

        // Проверка: совпадает ли введенный текущий пароль с тем, что в базе
        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Указанный текущий пароль неверен.']);
        }

        // Хешируем и сохраняем новый пароль
        $customer->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Пароль был успешно изменен.');
    }
}
