document.addEventListener('DOMContentLoaded', () => {
    const cartSidebar = document.getElementById('cartSidebar');
    const cartOverlay = document.getElementById('cartOverlay');
    const cartBtn = document.querySelector('.cart-btn');
    const closeSidebarBtn = document.getElementById('closeCartBtn');
    const sidebarItemsContainer = document.querySelector('.cart-sidebar-content');

    // ОТКРЫТИЕ сайдбара
    if (cartBtn && cartSidebar) {
        cartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            cartSidebar.classList.add('is-open');
            if (cartOverlay) cartOverlay.classList.add('is-open');
        });
    }

    // ЗАКРЫТИЕ по кнопке-крестику
    if (closeSidebarBtn && cartSidebar) {
        closeSidebarBtn.addEventListener('click', () => {
            cartSidebar.classList.remove('is-open');
            if (cartOverlay) cartOverlay.classList.remove('is-open');
        });
    }

    // ЗАКРЫТИЕ при клике на оверлей
    if (cartOverlay && cartSidebar) {
        cartOverlay.addEventListener('click', () => {
            cartSidebar.classList.remove('is-open');
            cartOverlay.classList.remove('is-open');
        });
    }

    // УДАЛЕНИЕ ИЗ САЙДБАРА (Перевешиваем на AJAX, так как localStorage нам больше не нужен)
    if (sidebarItemsContainer) {
        sidebarItemsContainer.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.cart-item-remove-sidebar');
            if (removeBtn) {
                const itemId = removeBtn.getAttribute('data-id');

                // Отправляем запрос на удаление в твой CartController->remove
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cart_item_id: itemId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Просто перезагружаем страницу, чтобы обновить корзину везде
                            window.location.reload();
                        }
                    });
            }
        });
    }

    // МЫ ПОЛНОСТЬЮ УБРАЛИ функцию renderSidebarCart(), которая стирала данные!
});
