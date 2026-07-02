<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LogoSetting;
use App\Models\NavigationItem;
use App\Mail\CustomerActivationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->to('/');
        }

        $logos = LogoSetting::first();
        $footerMenus = NavigationItem::all();

        return view('pages.auth.login', compact('logos', 'footerMenus'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Ищем пользователя, чтобы проверить статус активации до логина
        $customer = Customer::where('email', $request->email)->first();

        if ($customer) {
            if ($customer->status === 'banned') {
                return back()->withErrors(['email' => 'Ваш аккаунт заблокирован администратором.'])->withInput();
            }

            if (!$customer->is_activated) {
                return back()->withErrors(['email' => 'Ваш аккаунт не активирован. Пожалуйста, проверьте вашу почту.'])->withInput();
            }
        }

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->to('/');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль.'])->withInput();
    }

    public function showRegister()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->to('/');
        }

        $logos = LogoSetting::first();
        $footerMenus = NavigationItem::all();

        return view('pages.auth.register', compact('logos', 'footerMenus'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
        ], [
            'email.unique' => 'Этот email уже зарегистрирован в системе.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен быть не менее 6 символов.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Создаем клиента с токеном активации
        $customer = Customer::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => 'active',
            'warning_count' => 0,
            'is_activated' => false, // Ждем активации
            'activation_token' => Str::random(40), // Генерация токена
        ]);

        // Отправка письма (на GoDaddy сработает напрямую синхронно)
        try {
            Mail::to($customer->email)->send(new CustomerActivationMail($customer));
        } catch (\Exception $e) {
            // Если на локалке не настроена почта, код не упадет
        }

        // Редиректим на главную и просим проверить почту
        return redirect()->to('/')->with('info', 'На вашу почту отправлено письмо со ссылкой для активации аккаунта.');
    }

    // Метод обработки клика по ссылке из письма
    public function activate($token)
    {
        $customer = Customer::where('activation_token', $token)->first();

        if (!$customer) {
            return redirect()->to('/')->with('error', 'Неверный или просроченный токен активации.');
        }

        // Активируем пользователя
        $customer->update([
            'is_activated' => true,
            'activation_token' => null, // Удаляем токен после использования
        ]);

        // Перенаправляем на главную с флагом успешной активации для вызова модалки
        return redirect()->to('/')->with('account_activated', true);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }
}
