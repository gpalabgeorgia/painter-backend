document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // СТИЛИ: СКРЫВАЕМ "1 ×" И КРАСНЫЙ КРЕСТИК
    // ==========================================
    const style = document.createElement('style');
    style.innerHTML = `
        .cart-sidebar-content .cart-item-price { font-size: 0 !important; }
        .cart-sidebar-content .cart-item-price * { font-size: 13px !important; }
        .cart-sidebar-content .cart-item-price { display: inline-block; font-size: 13px !important; color: #666 !important; }
        .cart-sidebar-content .cart-item-remove-sidebar { color: #999999 !important; font-weight: normal !important; font-size: 18px !important; transition: color 0.2s ease; }
        .cart-sidebar-content .cart-item-remove-sidebar:hover { color: #333333 !important; }
    `;
    document.head.appendChild(style);

    // ==========================================
    // 1. ОБЩИЕ ПЕРЕМЕННЫЕ И СИНХРОНИЗАЦИЯ
    // ==========================================
    const sidebarItemsContainer = document.querySelector('.cart-sidebar-content');
    const sidebarSubtotal = document.querySelector('.subtotal-amount');
    const headerCartTotal = document.getElementById('headerCartTotal');
    const headerCartBadge = document.getElementById('headerCartBadge');

    function getCsrfToken() {
        const metaCsrf = document.querySelector('meta[name="csrf-token"]');
        const inputCsrf = document.querySelector('input[name="_token"]');
        return metaCsrf ? metaCsrf.getAttribute('content') : (inputCsrf ? inputCsrf.value : '');
    }

    function formatToEuro(value) {
        const num = parseFloat(String(value).replace(/[$\u20AC]/g, '').trim());
        return isNaN(num) ? '€0.00' : `€${num.toFixed(2)}`;
    }

    // Прямая синхронизация элементов на основе переданных данных из бэкенда
    function updateCartUI(items, total, count) {
        const formattedTotal = formatToEuro(total);

        // Обновляем счетчики и суммы в шапке
        if (headerCartBadge) headerCartBadge.textContent = count;
        if (headerCartTotal) headerCartTotal.textContent = formattedTotal;
        if (sidebarSubtotal) sidebarSubtotal.textContent = formattedTotal;

        const altCartBadge = document.querySelector('.cart-badge');
        if (altCartBadge) altCartBadge.textContent = count;
        const altCartTotal = document.querySelector('.cart-total');
        if (altCartTotal) altCartTotal.textContent = formattedTotal;

        // Перерисовываем сайдбар на лету
        if (sidebarItemsContainer) {
            if (count === 0) {
                sidebarItemsContainer.innerHTML = '<div style="padding: 40px 20px; color: #999; text-align: center; font-size: 14px; font-family: sans-serif;">Your cart is empty</div>';
                return;
            }

            let html = '';
            items.forEach(item => {
                html += `
                    <div class="cart-sidebar-item" data-cart-item-id="${item.id}" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; padding-bottom:15px; border-bottom:1px solid #eee;">
                        <div style="display:flex; align-items:center;">
                            <img src="${item.img || ''}" style="width:50px; height:50px; object-fit:cover; border-radius:4px; margin-right:10px;">
                            <div>
                                <h5 style="margin:0; font-size:14px; font-weight:bold; color:#333;">${item.title}</h5>
                                <span class="cart-item-price" style="font-size:13px; color:#666;">${formatToEuro(item.price)}</span>
                            </div>
                        </div>
                        <a href="#" class="cart-item-remove-sidebar" data-id="${item.id}">&times;</a>
                    </div>
                `;
            });
            sidebarItemsContainer.innerHTML = html;
        }
    }

    // Железный фоновый запрос к базе данных Laravel при загрузке любой страницы
    function serverCartSessionSync() {
        fetch('/cart/data', {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        })
            .then(response => {
                if (response.ok) return response.json();
                throw new Error('Not authenticated');
            })
            .then(data => {
                // Накатываем эталонные данные из базы, убирая любые несостыковки сессии
                updateCartUI(data.items, data.total, data.count);
            })
            .catch(err => console.log('Пользователь не авторизован или ошибка роута'));
    }

    // Запускаем проверку базы данных сразу при заходе на страницу (уберет воскрешение товара)
    serverCartSessionSync();

    // ==========================================
    // 2. МОДАЛЬНЫЕ ОКНА
    // ==========================================
    const addConfirmModalHtml = `
        <div id="addToCartConfirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center; opacity:0; transition:opacity 0.15s ease; backdrop-filter:blur(4px); font-family:sans-serif;">
            <div id="addToCartConfirmBox" style="background:#fff; padding:30px; width:100%; max-width:420px; border-radius:12px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.15); transform:translateY(-10px); transition:transform 0.15s ease;">
                <h4 style="margin:0 0 15px 0; font-size:18px; color:#333; font-weight:600;">Вы собираетесь добавить в корзину продукт</h4>
                <div style="display:flex; align-items:center; background:#f8f9fa; padding:15px; border-radius:8px; margin-bottom:25px; text-align:left;">
                    <img id="addModalProductImg" src="" alt="" style="width:70px; height:70px; object-fit:cover; border-radius:6px; margin-right:15px; background:#eee;">
                    <div>
                        <div id="addModalProductTitle" style="font-weight:bold; font-size:15px; color:#111; margin-bottom:4px; line-height:1.3;"></div>
                        <div id="addModalProductPrice" style="color:#e44d26; font-weight:bold; font-size:16px;"></div>
                    </div>
                </div>
                <div style="display:flex; gap:12px;">
                    <button id="addModalCancelBtn" style="flex:1; padding:12px; background:#f1f3f5; border:none; border-radius:6px; cursor:pointer; font-weight:bold; color:#495057;">Отменить</button>
                    <button id="addModalSubmitBtn" style="flex:1; padding:12px; background:#000; border:none; border-radius:6px; cursor:pointer; font-weight:bold; color:#fff;">Добавить</button>
                </div>
            </div>
        </div>
    `;

    const addSuccessModalHtml = `
        <div id="addToCartSuccessModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:999999; justify-content:center; align-items:center; opacity:0; transition:opacity 0.15s ease; backdrop-filter:blur(2px); font-family:sans-serif;">
            <div id="addToCartSuccessBox" style="background:#fff; padding:25px; width:100%; max-width:350px; border-radius:12px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.15); transform:translateY(-10px); transition:transform 0.15s ease;">
                <div style="width:50px; height:50px; background:#e6f4ea; color:#137333; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; margin:0 auto 15px auto; font-weight:bold;">✓</div>
                <h4 style="margin:0 0 20px 0; font-size:17px; color:#202124; font-weight:600;">Продукт добавлен в корзину</h4>
                <button id="successModalCloseBtn" style="width:100%; padding:10px; background:#000; border:none; border-radius:6px; cursor:pointer; font-weight:bold; color:#fff;">Отлично</button>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', addConfirmModalHtml);
    document.body.insertAdjacentHTML('beforeend', addSuccessModalHtml);

    const addModal = document.getElementById('addToCartConfirmModal');
    const addBox = document.getElementById('addToCartConfirmBox');
    const addModalImg = document.getElementById('addModalProductImg');
    const addModalTitle = document.getElementById('addModalProductTitle');
    const addModalPrice = document.getElementById('addModalProductPrice');
    const addModalCancelBtn = document.getElementById('addModalCancelBtn');
    const addModalSubmitBtn = document.getElementById('addModalSubmitBtn');

    const successModal = document.getElementById('addToCartSuccessModal');
    const successBox = document.getElementById('addToCartSuccessBox');
    const successModalCloseBtn = document.getElementById('successModalCloseBtn');

    let currentProductIdToAdd = null;
    let backupProductData = {};

    function openAddModal(id, title, img, price) {
        currentProductIdToAdd = id;
        backupProductData = { title, img, price };

        if (addModal && addBox) {
            addModalImg.src = img || '';
            addModalTitle.textContent = title || 'Без названия';
            addModalPrice.textContent = formatToEuro(price);
            addModal.style.display = 'flex';
            setTimeout(() => { addModal.style.opacity = '1'; addBox.style.transform = 'translateY(0)'; }, 1);
        }
    }

    function closeAddModal() {
        if (addModal && addBox) {
            addModal.style.opacity = '0'; addBox.style.transform = 'translateY(-10px)';
            setTimeout(() => { addModal.style.display = 'none'; currentProductIdToAdd = null; }, 150);
        }
    }

    function openSuccessModal() {
        if (successModal && successBox) {
            successModal.style.display = 'flex';
            setTimeout(() => { successModal.style.opacity = '1'; successBox.style.transform = 'translateY(0)'; }, 1);
            setTimeout(closeSuccessModal, 1500);
        }
    }

    function closeSuccessModal() {
        if (successModal && successBox) {
            successModal.style.opacity = '0'; successBox.style.transform = 'translateY(-10px)';
            setTimeout(() => { successModal.style.display = 'none'; }, 150);
        }
    }

    if (addModalCancelBtn) addModalCancelBtn.addEventListener('click', closeAddModal);
    if (successModalCloseBtn) successModalCloseBtn.addEventListener('click', closeSuccessModal);

    // Клик на добавление товара
    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.product-add-btn');
        if (btn) {
            e.preventDefault(); e.stopPropagation();

            const isGuest = !document.querySelector('a[href*="/account"]') && !document.querySelector('a[href*="/logout"]');
            if (isGuest) { window.location.href = '/login'; return; }

            const productId = btn.getAttribute('data-id');
            if (!productId) return;

            const productCard = btn.closest('.product-card') || btn.closest('.single-product-container') || btn.closest('[class*="col-"]') || btn.parentElement;

            let imgUrl = btn.getAttribute('data-img') || (productCard.querySelector('img') ? productCard.querySelector('img').src : '');
            let titleText = btn.getAttribute('data-title') || (productCard.querySelector('.product-title') || productCard.querySelector('h1') || productCard.querySelector('h2')).textContent.trim();
            let priceText = btn.getAttribute('data-price') || (productCard.querySelector('.product-price') || productCard.querySelector('.price')).textContent.trim();

            openAddModal(productId, titleText || "Картина", imgUrl, priceText || "€0.00");
        }
    });

    // Нажатие кнопки подтверждения в модалке (Мгновенный визуальный апдейт + фоновый fetch)
    if (addModalSubmitBtn) {
        addModalSubmitBtn.addEventListener('click', function () {
            if (!currentProductIdToAdd) return;

            // Оптимистично увеличиваем значения, чтобы убрать лаг
            let currentQty = parseInt(headerCartBadge ? headerCartBadge.textContent : '0') || 0;
            let currentSum = parseFloat(headerCartTotal ? headerCartTotal.textContent.replace(/[$\u20AC]/g, '').trim() : '0') || 0;
            const targetPrice = parseFloat(addModalPrice.textContent.replace(/[$\u20AC]/g, '').trim()) || 0;

            if (headerCartBadge) headerCartBadge.textContent = currentQty + 1;
            if (headerCartTotal) headerCartTotal.textContent = formatToEuro(currentSum + targetPrice);

            closeAddModal();
            openSuccessModal();

            fetch("/cart/add", {
                method: "POST",
                headers: { "Content-Type": "application/json", "Accept": "application/json", "X-CSRF-TOKEN": getCsrfToken() },
                body: JSON.stringify({ product_id: currentProductIdToAdd })
            })
                .then(() => {
                    // После успешной записи на бэкенде, перечитываем точную структуру из БД
                    serverCartSessionSync();
                })
                .catch(error => console.error(error));
        });
    }

    // ====================================================================
    // 3. МГНОВЕННОЕ УДАЛЕНИЕ ИЗ САЙДБАРА (0 СЕКУНД ОЖИДАНИЯ)
    // ====================================================================
    if (sidebarItemsContainer) {
        sidebarItemsContainer.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.cart-item-remove-sidebar');
            if (removeBtn) {
                e.preventDefault(); e.stopPropagation();

                const itemId = removeBtn.getAttribute('data-id');
                const cartItemRow = removeBtn.closest('.cart-sidebar-item');
                if (!itemId) return;

                // Мгновенно стираем элемент с экрана пользователя
                if (cartItemRow) cartItemRow.remove();

                // Оптимистичный пересчет числовых значений прямо на фронте
                let newSubtotal = 0;
                let newTotalQty = 0;
                document.querySelectorAll('.cart-sidebar-content .cart-sidebar-item').forEach(item => {
                    let pText = item.querySelector('.cart-item-price').textContent || '0';
                    if (pText.includes('×')) pText = pText.split('×')[1];
                    const price = parseFloat(pText.replace(/[$\u20AC]/g, '').trim());
                    if (!isNaN(price)) newSubtotal += price;
                    newTotalQty++;
                });

                // ИСПРАВЛЕНО: Меняем только текстовые данные в шапке, не ломая структуру оставшихся элементов в DOM
                const formattedTotal = formatToEuro(newSubtotal);
                if (headerCartBadge) headerCartBadge.textContent = newTotalQty;
                if (headerCartTotal) headerCartTotal.textContent = formattedTotal;
                if (sidebarSubtotal) sidebarSubtotal.textContent = formattedTotal;

                const altCartBadge = document.querySelector('.cart-badge');
                if (altCartBadge) altCartBadge.textContent = count;
                const altCartTotal = document.querySelector('.cart-total');
                if (altCartTotal) altCartTotal.textContent = formattedTotal;

                if (newTotalQty === 0) {
                    sidebarItemsContainer.innerHTML = '<div style="padding: 40px 20px; color: #999; text-align: center; font-size: 14px; font-family: sans-serif;">Your cart is empty</div>';
                }

                // Отправляем запрос удаления в бэкенд
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: { "Content-Type": "application/json", "Accept": "application/json", "X-CSRF-TOKEN": getCsrfToken() },
                    body: JSON.stringify({ cart_item_id: itemId })
                })
                    .then(() => {
                        // Контрольный запрос в БД, чтобы убедиться, что бэкенд зафиксировал изменения
                        serverCartSessionSync();
                    })
                    .catch(error => console.error(error));
            }
        });
    }

    // ==========================================
    // 4. СТРАНИЦА КОРЗИНЫ (/cart)
    // ==========================================
    const cartWrapper = document.getElementById('cartProductsListWrapper');
    if (cartWrapper) {
        // Ошибка исправлена здесь: заменена квадратная скобка на круглую
        const removeUrl = cartWrapper.getAttribute('data-remove-url') || '/cart/remove';
        const csrfToken = cartWrapper.getAttribute('data-csrf');
        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteBox = document.getElementById('confirmDeleteBox');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const submitDeleteBtn = document.getElementById('submitDeleteBtn');

        let itemRowToDelete = null; let itemIdToDelete = null;

        cartWrapper.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-main-cart-btn');
            if (removeBtn) {
                e.preventDefault(); e.stopPropagation();
                itemRowToDelete = removeBtn.closest('.cart-item');
                itemIdToDelete = removeBtn.getAttribute('data-id');
                if (deleteModal && deleteBox) {
                    deleteModal.style.display = 'flex';
                    setTimeout(() => { deleteModal.style.opacity = '1'; deleteBox.style.transform = 'translateY(0)'; }, 1);
                }
            }
        });

        if (submitDeleteBtn) {
            submitDeleteBtn.addEventListener('click', function () {
                if (!itemRowToDelete || !itemIdToDelete) return;

                if (itemRowToDelete) itemRowToDelete.remove();
                if (deleteModal) deleteModal.style.display = 'none';

                fetch(removeUrl, {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "Accept": "application/json", "X-CSRF-TOKEN": csrfToken || getCsrfToken() },
                    body: JSON.stringify({ cart_item_id: itemIdToDelete })
                })
                    .then(() => {
                        serverCartSessionSync();
                        if (document.querySelectorAll('.cart-item').length === 0) window.location.reload();
                    });
            });
        }
        if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => deleteModal.style.display = 'none');
    }

    // ==========================================
    // 5. ПОЛНОЭКРАННЫЙ ПРЕДПРОСМОТР КАРТИНЫ (QUICK VIEW)
    // ==========================================
    const quickModal = document.getElementById('quickViewModal');
    const modalImg = document.getElementById('modalImg');
    const modalTitle = document.getElementById('modalTitle');
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Находим белый контейнер (блок-рамку) внутри модалки
    let contentBox = null;
    if (quickModal) {
        contentBox = quickModal.querySelector('div');

        // Базовые стили модалки для размытия и плавности
        quickModal.style.opacity = '0';
        quickModal.style.transition = 'opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
        quickModal.style.backgroundColor = 'rgba(0, 0, 0, 0.6)';
        quickModal.style.backdropFilter = 'blur(12px)';
        quickModal.style.webkitBackdropFilter = 'blur(12px)';

        if (contentBox) {
            // Навешиваем плавный переход на ВЕСЬ белый контейнер
            contentBox.style.transform = 'scale(0.92)';
            contentBox.style.transition = 'transform 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            contentBox.style.cursor = 'zoom-in'; // Лупа плюс при наведении на рамку

            // Клик по ВСЕМУ белому контейнеру (включая рамку и текст) для увеличения
            contentBox.addEventListener('click', function (e) {
                e.stopPropagation(); // Чтобы клик не закрывал модалку

                if (this.style.transform === 'scale(1.3)') {
                    this.style.transform = 'scale(1)';
                    this.style.cursor = 'zoom-in';
                } else {
                    this.style.transform = 'scale(1.3)'; // Увеличиваем рамку целиком в 1.3 раза (можно поставить 1.4 или 1.5)
                    this.style.cursor = 'zoom-out';
                }
            });
        }
    }

    // Слушаем клик по кнопке «Глаз» с классом view-product-btn
    document.body.addEventListener('click', function (e) {
        const viewBtn = e.target.closest('.view-product-btn');
        if (viewBtn) {
            e.preventDefault();

            const imgUrl = viewBtn.getAttribute('data-img');
            const titleText = viewBtn.getAttribute('data-title') || 'Без названия';

            if (!imgUrl) return;

            // Сбрасываем масштаб контейнера к исходному при открытии новой картины
            if (contentBox) {
                contentBox.style.transform = 'scale(0.92)';
                contentBox.style.cursor = 'zoom-in';
            }
            if (modalImg) modalImg.style.transform = 'none'; // Убираем старый зум с самой картинки

            modalImg.src = imgUrl;
            if (modalTitle) modalTitle.textContent = titleText;

            quickModal.style.display = 'flex';

            setTimeout(() => {
                quickModal.style.opacity = '1';
                if (contentBox) contentBox.style.transform = 'scale(1)';
            }, 10);
        }
    });

    // Функция мягкого закрытия окна просмотра
    function closeQuickModal() {
        if (quickModal) {
            quickModal.style.opacity = '0';
            if (contentBox) contentBox.style.transform = 'scale(0.92)';

            setTimeout(() => {
                quickModal.style.display = 'none';
                if (modalImg) modalImg.src = '';
                if (modalTitle) modalTitle.textContent = '';
            }, 300);
        }
    }

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeQuickModal);

    if (quickModal) {
        quickModal.addEventListener('click', function (e) {
            if (e.target === quickModal) {
                closeQuickModal();
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && quickModal.style.display === 'flex') {
            closeQuickModal();
        }
    });

    // ==========================================
    // 6. ОСТАЛЬНАЯ ЛОГИКА (ПЛЕЕР И ПОИСК)
    // ==========================================
    const videoWrapper = document.getElementById('customVideoPlayer');
    const video = document.getElementById('mainVideo');
    const playBtn = document.getElementById('videoPlayBtn');

    if (videoWrapper && video && playBtn) {
        function toggleVideo() {
            if (video.paused) { video.play(); videoWrapper.classList.add('is-playing'); video.setAttribute('controls', 'true'); }
            else { video.pause(); videoWrapper.classList.remove('is-playing'); }
        }
        playBtn.addEventListener('click', toggleVideo); video.addEventListener('click', toggleVideo);
    }

    const searchTriggerBtn = document.getElementById('searchTriggerBtn');
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    if (searchTriggerBtn && searchInput && searchForm) {
        searchTriggerBtn.addEventListener('click', function (e) {
            if (searchInput.style.width === '0px' || searchInput.style.width === '') {
                e.preventDefault(); searchInput.style.width = '180px'; searchInput.style.opacity = '1'; searchInput.style.paddingLeft = '10px'; searchInput.style.paddingRight = '10px'; searchInput.focus();
            } else if (searchInput.value.trim() !== '') { searchForm.submit(); }
        });
    }
});
