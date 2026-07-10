<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;

class CustomerAddressController extends Controller
{
    public function store(Request $request)
    {
        // 1. Валидация входящих данных из модального окна
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'nullable|string|max:20',
            'country'    => 'required|string|max:255',
            'region'     => 'nullable|string|max:255',
            'city'       => 'required|string|max:255',
            'zip_code'   => 'required|string|max:20',
            'address'    => 'required|string',
        ]);

        // 2. Получаем ID авторизованного клиента через его гард
        $customerId = auth()->guard('customer')->id();

        if (!$customerId) {
            return redirect()->back()->withErrors(['error' => 'Сессия истекла. Пожалуйста, войдите заново.']);
        }

        // 3. Создаем новый адрес в базе данных
        CustomerAddress::create(array_merge($validated, [
            'customer_id' => $customerId
        ]));

        // 4. Возвращаем пользователя назад с зеленым уведомлением об успехе
        return redirect()->back()->with('success', 'Новый адрес доставки успешно добавлен!');
    }

    public function destroy($id)
    {
        $customerId = auth()->guard('customer')->id();

        // Находим адрес, который принадлежит ИМЕННО этому пользователю
        $address = CustomerAddress::where('id', $id)->where('customer_id', $customerId)->first();

        if ($address) {
            $address->delete();
            return redirect()->back()->with('success', 'Адрес успешно удален!');
        }

        return redirect()->back()->withErrors(['error' => 'Адрес не найден или у вас нет прав на его удаление.']);
    }
}
