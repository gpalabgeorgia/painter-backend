<div class="cart-sidebar" id="cartSidebar">
    <!-- Шапка сайдбара -->
    <div class="cart-sidebar-header">
        <h2 class="cart-sidebar-title">Shopping Cart</h2>
        <button class="cart-sidebar-close" id="closeCartBtn">
            <!-- Иконка крестика (X) -->
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <!-- Список товаров в корзине -->
    <div class="cart-sidebar-content">
        <!-- Пример товара (как на скрине image_33063e.png) -->
        <div class="cart-sidebar-item">
            <div class="cart-item-img-wrapper">
                <img src="path-to-your-art/majesty.jpg" alt="Majesty" class="cart-item-thumb">
            </div>
            <div class="cart-item-details">
                <h4 class="cart-item-name">Majesty</h4>
                <div class="cart-item-meta">
                    <span class="cart-item-qty">1</span> &times; <span class="cart-item-price">$400.00</span>
                </div>
            </div>
            <button class="cart-item-remove">
                <!-- Маленький крестик удаления товара -->
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#999999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
    </div>
    <!-- Подвал сайдбара (Итого и Кнопки перехода) -->
    <div class="cart-sidebar-footer">
        <div class="cart-sidebar-subtotal">
            <span>Subtotal:</span>
            <span class="subtotal-amount">$400.00</span>
        </div>
        <div class="cart-sidebar-actions">
            <a href="cart.html" class="cart-action-btn btn-view-cart">VIEW CART</a>
            <a href="checkout.html" class="cart-action-btn btn-checkout">CHECKOUT</a>
        </div>
    </div>
</div>
