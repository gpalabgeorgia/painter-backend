<div class="cart-sidebar" id="cartSidebar">
    <!-- Шапка сайдбара -->
    <div class="cart-sidebar-header">
        <h2 class="cart-sidebar-title">Shopping Cart</h2>
        <button class="cart-sidebar-close" id="closeCartBtn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    @php
        // Берем ID строго через проверенный guard customer
        $customerId = auth()->guard('customer')->id();
        $sidebarItems = collect();
        $sidebarSubtotal = 0;

        if ($customerId) {
            // Запрашиваем элементы именно по customer_id
            $sidebarItems = \App\Models\CartItem::with('product')
                ->where('customer_id', $customerId)
                ->get();

            foreach ($sidebarItems as $item) {
                if ($item->product) {
                    // Используем price, так как это поле подтверждено дебагом
                    $sidebarSubtotal += ($item->product->price ?? 0) * $item->quantity;
                }
            }
        }
    @endphp

        <!-- Список товаров в корзине -->
    <div class="cart-sidebar-content">
        @if($sidebarItems->isEmpty())
            <div style="padding: 40px 20px; color: #999; text-align: center; font-size: 14px; font-family: sans-serif;">
                Your cart is empty
            </div>
        @else
            @foreach($sidebarItems as $item)
                @if($item->product)
                    <div class="cart-sidebar-item" data-id="{{ $item->id }}" style="display: flex; align-items: center; justify-content: space-between; padding: 15px 20px; border-bottom: 1px solid #eee; gap: 15px;">
                        <!-- 1. Фото продукта -->
                        <div class="cart-item-img-wrapper" style="width: 50px; height: 50px; flex-shrink: 0;">
                            <img src="{{ asset('img/products_img/' . $item->product->image) }}" alt="{{ $item->product->title }}" class="cart-item-thumb" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>

                        <!-- 2. Название (title вместо name), цена и количество -->
                        <div class="cart-item-details" style="flex-grow: 1;">
                            <h4 class="cart-item-name" style="margin: 0 0 5px 0; font-size: 14px; color: #1a1a1a;">{{ $item->product->title }}</h4>
                            <div class="cart-item-meta" style="font-size: 13px; color: #666;">
                                <span class="cart-item-qty">{{ $item->quantity }}</span> &times; <span class="cart-item-price">${{ number_format($item->product->price, 2) }}</span>
                            </div>
                        </div>

                        <!-- 3. Кнопка удаления -->
                        <button class="cart-item-remove-sidebar" data-id="{{ $item->id }}" style="background: none; border: none; cursor: pointer; padding: 5px;">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#999999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                @endif
            @endforeach
        @endif
    </div>

    <!-- Подвал сайдбара -->
    <div class="cart-sidebar-footer">
        <div class="cart-sidebar-subtotal" style="display: flex; justify-content: space-between; padding: 20px; font-weight: 600; border-top: 1px solid #eee;">
            <span>Subtotal:</span>
            <span class="subtotal-amount">${{ number_format($sidebarSubtotal, 2) }}</span>
        </div>
        <div class="cart-sidebar-actions" style="padding: 0 20px 20px 20px; display: flex; flex-direction: column; gap: 10px;">
            <a href="{{ url('cart') }}" class="cart-action-btn btn-view-cart" style="display: block; text-align: center; padding: 12px; background: #fff; color: #000; border: 1px solid #000; text-decoration: none; font-size: 12px; font-weight: bold; letter-spacing: 1px;">VIEW CART</a>
            <a href="#" class="cart-action-btn btn-checkout" style="display: block; text-align: center; padding: 12px; background: #000; color: #fff; border: 1px solid #000; text-decoration: none; font-size: 12px; font-weight: bold; letter-spacing: 1px;">CHECKOUT</a>
        </div>
    </div>
</div>
