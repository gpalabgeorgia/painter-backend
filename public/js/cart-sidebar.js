document.addEventListener('DOMContentLoaded', () => {
    const cartSidebar = document.getElementById('cartSidebar');
    const cartOverlay = document.getElementById('cartOverlay'); // Находим оверлей
    const cartBtn = document.querySelector('.cart-btn');
    const closeSidebarBtn = document.getElementById('closeCartBtn');
    const sidebarItemsContainer = document.querySelector('.cart-sidebar-content');
    const sidebarSubtotal = document.querySelector('.subtotal-amount');

    const headerCartTotal = document.getElementById('headerCartTotal');
    const headerCartBadge = document.getElementById('headerCartBadge');

    function renderSidebarCart() {
        const savedCart = localStorage.getItem('shoppingCartArray');
        const cartData = savedCart ? JSON.parse(savedCart) : [];

        let itemsHTML = '';
        let totalSum = 0;
        let totalQty = 0;

        if (cartData.length === 0) {
            if (sidebarItemsContainer) {
                sidebarItemsContainer.innerHTML = '<div style="padding:20px; color:#999; text-align:center; font-size:14px;">Your cart is empty</div>';
            }
        } else {
            cartData.forEach((item, index) => {
                const itemTotal = item.qty * item.price;
                totalSum += itemTotal;
                totalQty += item.qty;

                itemsHTML += `
                    <div class="cart-sidebar-item">
                        <div class="cart-item-img-wrapper">
                            <img src="${item.img}" alt="${item.name}" class="cart-item-thumb">
                        </div>
                        <div class="cart-item-details">
                            <h4 class="cart-item-name">${item.name}</h4>
                            <div class="cart-item-meta">
                                <span class="cart-item-qty">${item.qty}</span> &times; <span class="cart-item-price">$${item.price.toFixed(2)}</span>
                            </div>
                        </div>
                        <button class="cart-item-remove" data-index="${index}">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#999999" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                        </button>
                    </div>
                `;
            });
            if (sidebarItemsContainer) sidebarItemsContainer.innerHTML = itemsHTML;
        }

        if (sidebarSubtotal) sidebarSubtotal.textContent = `$${totalSum.toFixed(2)}`;
        if (headerCartTotal) headerCartTotal.textContent = `$${totalSum.toFixed(2)}`;
        if (headerCartBadge) headerCartBadge.textContent = totalQty;
    }

    // ОТКРЫТИЕ (добавляем класс is-open строго по твоему CSS)
    if (cartBtn && cartSidebar) {
        cartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cartSidebar.classList.add('is-open'); // Вот он!
            if (cartOverlay) cartOverlay.classList.add('is-open'); // Включаем затемнение фона
        });
    }

    // ЗАКРЫТИЕ по кнопке-крестику
    if (closeSidebarBtn && cartSidebar) {
        closeSidebarBtn.addEventListener('click', () => {
            cartSidebar.classList.remove('is-open');
            if (cartOverlay) cartOverlay.classList.remove('is-open'); // Убираем затемнение
        });
    }

    // ЗАКРЫТИЕ при клике на само затемненное пространство вокруг сайдбара
    if (cartOverlay && cartSidebar) {
        cartOverlay.addEventListener('click', () => {
            cartSidebar.classList.remove('is-open');
            cartOverlay.classList.remove('is-open');
        });
    }

    if (sidebarItemsContainer) {
        sidebarItemsContainer.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.cart-item-remove');
            if (removeBtn) {
                const indexToRemove = removeBtn.getAttribute('data-index');
                const savedCart = localStorage.getItem('shoppingCartArray');
                let cartData = savedCart ? JSON.parse(savedCart) : [];

                cartData.splice(indexToRemove, 1);
                localStorage.setItem('shoppingCartArray', JSON.stringify(cartData));
                renderSidebarCart();
            }
        });
    }

    renderSidebarCart();
});