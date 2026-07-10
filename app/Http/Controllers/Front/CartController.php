<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NavigationItem;
use App\Models\HeaderContact;
use App\Models\LogoSetting;
use App\Models\SubscribeSection;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    // Метод для отображения страницы корзины
    public function index()
    {
        $footerMenus = NavigationItem::all();
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();
        $subscribeSection = SubscribeSection::first();

        $customerId = Auth::guard('customer')->id();

        // Перестраховка: перед выводом корзины сбрасываем количество всех картин до 1, если там застряли старые дубли
        CartItem::where('customer_id', $customerId)->update(['quantity' => 1]);

        $cartItems = CartItem::with('product')->where('customer_id', $customerId)->get();

        return view('pages.cart.index', compact(
            'cartItems',
            'footerMenus',
            'contactData',
            'logos',
            'subscribeSection'
        ));
    }

    // НОВЫЙ МЕТОД: Железная синхронизация базы данных с фронтендом без localStorage
    public function getCartData(): JsonResponse
    {
        $customerId = Auth::guard('customer')->id();
        if (!$customerId) {
            return response()->json(['items' => [], 'total' => 0, 'count' => 0], 401);
        }

        $cartItems = CartItem::with('product')->where('customer_id', $customerId)->get();

        $itemsData = [];
        $totalPrice = 0;

        foreach ($cartItems as $item) {
            if ($item->product) {
                $price = (float)$item->product->price;
                $totalPrice += $price;

                // Собираем данные, адаптируя под структуру твоего проекта
                $itemsData[] = [
                    'id' => $item->id, // cart_item_id для удаления
                    'product_id' => $item->product_id,
                    'title' => $item->product->title ?? 'Картина',
                    'price' => $price,
                    // Если картинка лежит в другой переменной (например, image или main_image), замени свойство ниже:
                    'img' => $item->product->image ? '/img/products_img/' . $item->product->image : '',
                ];
            }
        }

        return response()->json([
            'items' => $itemsData,
            'total' => $totalPrice,
            'count' => count($itemsData)
        ]);
    }

    // Метод добавления товара с расчетом количества и суммы для хедера
    public function add(Request $request)
    {
        // ЖЕЛЕЗНАЯ ПРОВЕРКА: Если гость — отдаем 200 OK с инструкцией редиректа
        if (!Auth::guard('customer')->check()) {
            return response()->json([
                'status' => 'unauthenticated',
                'redirect' => url('/login')
            ], 200);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $customerId = Auth::guard('customer')->id();
        $productId = $request->product_id;

        $cartItem = CartItem::where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();

        // ИСПРАВЛЕНО: Если картина уже есть в корзине, мы БОЛЬШЕ НЕ ИНКРЕМЕНТИРУЕМ её.
        // Количество строго остается равным 1, просто отдаем успешный статус.
        if (!$cartItem) {
            CartItem::create([
                'customer_id' => $customerId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        // 1. Считаем общее количество предметов в корзине (теперь 1 картина = 1 шт)
        $totalItemsCount = CartItem::where('customer_id', $customerId)->count();

        // 2. Считаем общую стоимость корзины для хедера
        $cartItems = CartItem::with('product')->where('customer_id', $customerId)->get();
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += ($item->product->price ?? 0); // Убрали умножение на quantity, цена берется напрямую
        }

        return response()->json([
            'success' => true,
            'message' => 'Product successfully added to cart!',
            'totalItems' => $totalItemsCount,
            'totalPrice' => number_format($totalPrice, 2, '.', '')
        ]);
    }

    // Метод для изменения количества товара (ЗАГЛУШКА: для уникальных картин количество всегда 1)
    public function update(Request $request)
    {
        return response()->json([
            'success' => false,
            'message' => 'Quantity for unique artwork cannot be changed.'
        ], 400);
    }

    // Метод для удаления товара из корзины (через AJAX) с возвратом свежих данных для хедера
    public function remove(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id'
        ]);

        $customerId = Auth::guard('customer')->id();

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('customer_id', $customerId)
            ->first();

        if ($cartItem) {
            $cartItem->delete();

            // ИСПРАВЛЕНО: После удаления считаем новые остатки корзины для моментальной синхронизации хедера на бэкенде
            $totalItemsCount = CartItem::where('customer_id', $customerId)->count();

            $cartItems = CartItem::with('product')->where('customer_id', $customerId)->get();
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $totalPrice += ($item->product->price ?? 0);
            }

            return response()->json([
                'success' => true,
                'totalItems' => $totalItemsCount,
                'totalPrice' => number_format($totalPrice, 2, '.', '')
            ]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Отображение страницы оформления заказа (Checkout)
     */
    public function checkout()
    {
        $footerMenus = NavigationItem::all();
        $contactData = HeaderContact::first();
        $logos = LogoSetting::first();
        // Получаем текущего авторизованного клиента по твоему гарду
        $customer = Auth::guard('customer')->user();

        // Если вдруг зашёл гость (неавторизован), кидаем его на логин
        if (!$customer) {
            return redirect()->route('login'); // или твой роут логина
        }
        // Пока просто возвращаем пустую страницу, которую создали
        return view('pages.cart.checkout', compact('footerMenus', 'contactData', 'logos', 'customer'));
    }
}
