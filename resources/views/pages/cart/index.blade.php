@extends('layouts.app')
@section('content')
    <section class="cart-page-section" style="padding: 50px 0;">
        <div class="cart-container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

            @if($cartItems->isEmpty())
                <!-- СОСТОЯНИЕ: ПУСТАЯ КОРЗИНА -->
                <div class="cart-empty-state" id="cartEmptyState">
                    <div class="cart-empty-notice" style="display: flex; align-items: center; gap: 10px; background: #f9f9f9; padding: 15px; border-top: 3px solid #333; margin-bottom: 20px;">
                        <span class="cart-notice-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line></svg>
                        </span>
                        <span class="cart-notice-text" style="font-size: 14px; color: #555;">Your cart is currently empty.</span>
                    </div>
                    <div class="cart-return-wrapper">
                        <a href="{{ url('/shop') }}" class="cart-return-btn" style="display: inline-block; background: #000; color: #fff; text-decoration: none; padding: 12px 25px; font-size: 13px; font-weight: bold; letter-spacing: 1px;">RETURN TO SHOP</a>
                    </div>
                </div>
            @else
                <!-- СОСТОЯНИЕ: В КОРЗИНЕ ЕСТЬ ТОВАРЫ -->
                <div class="cart-products-list-wrapper" id="cartProductsListWrapper"
                     data-update-url="{{ route('cart.update') }}"
                     data-remove-url="{{ route('cart.remove') }}"
                     data-csrf="{{ csrf_token() }}">
                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">

                        <!-- Список товаров -->
                        <div class="cart-items-list" style="background: #fff; border: 1px solid #eee; border-radius: 4px; padding: 20px;">
                            @php $totalPrice = 0; @endphp
                            @foreach($cartItems as $item)
                                @if($item->product)
                                    @php $totalPrice += ($item->product->price ?? 0); @endphp
                                    <div class="cart-item" data-id="{{ $item->id }}" style="display: flex; align-items: center; justify-content: space-between; padding: 20px 0; border-bottom: 1px solid #f5f5f5; gap: 20px;">

                                        <div style="display: flex; align-items: center; gap: 20px; flex-grow: 1;">
                                            <!-- 1. Фото картины (уменьшено вполовину) -->
                                            <div class="cart-item-img-wrapper" style="width: 75px; height: 75px; flex-shrink: 0; background: #fdfdfdfd; border-radius: 2px; overflow: hidden; border: 1px solid #eaeaea;">
                                                <img src="{{ asset('img/products_img/' . $item->product->image) }}" alt="{{ $item->product->title }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                            </div>

                                            <!-- 2. Название картины -->
                                            <div style="flex-grow: 1;">
                                                <h4 style="margin: 0; font-size: 16px; color: #333; font-weight: 500;">{{ $item->product->title ?? $item->product->name }}</h4>
                                            </div>
                                        </div>

                                        <!-- 3. Цена, Просмотр и Удаление -->
                                        <div style="display: flex; align-items: center; gap: 25px; flex-shrink: 0;">
                                            <span class="cart-item-price-wrapper" style="font-weight: bold; font-size: 16px; color: #1a1a1a; min-width: 80px; text-align: right;">
                                                ${{ number_format($item->product->price, 2) }}
                                            </span>

                                            <!-- Кнопка «Глаз» для модального окна -->
                                            <button type="button" class="view-product-btn"
                                                    data-img="{{ asset('img/products_img/' . $item->product->image) }}"
                                                    data-title="{{ $item->product->title ?? $item->product->name }}"
                                                    style="background: none; border: none; cursor: pointer; padding: 5px; display: flex; align-items: center; transition: opacity 0.2s;"
                                                    title="Quick View"
                                                    onmouseover="this.style.opacity='0.7'" onmouseout="this.style.opacity='1'">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </button>

                                            <!-- Кнопка удаления -->
                                            <button type="button" class="remove-main-cart-btn" data-id="{{ $item->id }}"
                                                    style="background: none; border: none; color: #ff4d4d; cursor: pointer; font-size: 22px; padding: 5px; display: flex; align-items: center; line-height: 1; transition: transform 0.2s;"
                                                    title="Remove item"
                                                    onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">&times;</button>
                                        </div>

                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Блок чека / Итого -->
                        <div class="cart-totals" style="background: #f9f9f9; border: 1px solid #eee; padding: 30px; border-radius: 4px; position: sticky; top: 20px;">
                            <h3 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #333; font-weight: 600; font-size: 18px; letter-spacing: 0.5px;">Cart Totals</h3>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 25px; font-size: 16px;">
                                <span style="color: #555;">Subtotal</span>
                                <span id="cartTotalSum" style="font-weight: bold; font-size: 18px; color: #000;">${{ number_format($totalPrice, 2) }}</span>
                            </div>
                            <a href="{{ url('/checkout') }}" style="display: block; background: #000; color: #fff; text-align: center; text-decoration: none; padding: 15px; font-weight: bold; font-size: 13px; letter-spacing: 1px; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">PROCEED TO CHECKOUT</a>
                        </div>

                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- МОДАЛЬНОЕ ОКНО ДЛЯ РАССМОТРЕНИЯ КАРТИНЫ -->
    <div id="quickViewModal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); align-items: center; justify-content: center; backdrop-filter: blur(5px);">
        <!-- max-width увеличен с 85% до 95%, чтобы контейнер стал шире -->
        <div style="position: relative; max-width: 95%; max-height: 95%; background: #fff; padding: 15px; border-radius: 4px; box-shadow: 0 10px 40px rgba(0,0,0,0.6); text-align: center;">
            <span id="closeModalBtn" style="position: absolute; top: -45px; right: 0; color: #fff; font-size: 42px; font-weight: 200; cursor: pointer; user-select: none; transition: color 0.2s;" onmouseover="this.style.color='#ff4d4d'" onmouseout="this.style.color='#fff'">&times;</span>

            <!-- max-height увеличен с 73vh до 85vh — теперь картина развернется во всей красе -->
            <img id="modalImg" src="" style="max-width: 100%; max-height: 85vh; object-fit: contain; display: block; margin: 0 auto; border-radius: 2px;">

            <h3 id="modalTitle" style="margin: 15px 0 5px 0; font-family: sans-serif; font-size: 20px; font-weight: 400; color: #222;"></h3>
        </div>
    </div>
    <!-- КРАСИВОЕ МОДАЛЬНОЕ ОКНО ПОДТВЕРЖДЕНИЯ УДАЛЕНИЯ -->
    <div id="confirmDeleteModal" style="display: none; position: fixed; z-index: 10000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center; backdrop-filter: blur(4px); opacity: 0; transition: opacity 0.2s ease;">
        <div style="background: #fff; padding: 30px; border-radius: 8px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: translateY(-20px); transition: transform 0.2s ease;" id="confirmDeleteBox">
            <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 20px; color: #333; font-weight: 600;">Remove Artwork?</h3>
            <p style="color: #666; font-size: 14px; margin-bottom: 25px; line-height: 1.5;">Are you sure you want to remove this unique artwork from your cart?</p>
            <div style="display: flex; gap: 15px; justify-content: center;">
                <button type="button" id="cancelDeleteBtn" style="flex: 1; background: #f5f5f5; color: #333; border: 1px solid #e0e0e0; padding: 12px 20px; font-weight: bold; font-size: 13px; letter-spacing: 1px; border-radius: 4px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#e8e8e8'" onmouseout="this.style.background='#f5f5f5'">CANCEL</button>
                <button type="button" id="submitDeleteBtn" style="flex: 1; background: #000; color: #fff; border: none; padding: 12px 20px; font-weight: bold; font-size: 13px; letter-spacing: 1px; border-radius: 4px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#ff4d4d'" onmouseout="this.style.background='#000'">REMOVE</button>
            </div>
        </div>
    </div>
    @include('sections.subscribe')
@endsection
