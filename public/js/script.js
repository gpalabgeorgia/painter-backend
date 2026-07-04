document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. ОБЩИЕ ПЕРЕМЕННЫЕ И ЭЛЕМЕНТЫ ХЕДЕРА/САЙДБАРА
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

    // Вспомогательная функция для форматирования цены строго в формат €XX.XX
    function formatToEuro(value) {
        const num = parseFloat(String(value).replace(/[$\u20AC]/g, '').trim());
        return isNaN(num) ? '€0.00' : `€${num.toFixed(2)}`;
    }

    // --- ГЛОБАЛЬНАЯ СИНХРОНИЗАЦИЯ С ЕДИНОЙ ВАЛЮТОЙ ЕВРО ---
    function globalHeaderSync() {
        const mainCartItems = document.querySelectorAll('#cartProductsListWrapper .cart-item');
        const sidebarItems = document.querySelectorAll('.cart-sidebar-content .cart-sidebar-item');

        const hasMainCart = mainCartItems.length > 0;
        const targetItems = hasMainCart ? mainCartItems : sidebarItems;
        const exactQty = targetItems.length;

        let exactSubtotal = 0;

        // Принудительно форматируем цены у уже существующих элементов в сайдбаре (убираем 1x)
        sidebarItems.forEach(item => {
            const priceTextElement = item.querySelector('.cart-item-price');
            if (priceTextElement) {
                let priceText = priceTextElement.textContent || '0';

                if (priceText.includes('×')) priceText = priceText.split('×')[1];
                else if (priceText.includes('x')) priceText = priceText.split('x')[1];

                priceTextElement.textContent = formatToEuro(priceText);
            }
        });

        if (hasMainCart) {
            mainCartItems.forEach(row => {
                const priceElement = row.querySelector('.cart-item-price-wrapper');
                if (priceElement) {
                    const price = parseFloat(priceElement.textContent.replace(/[$\u20AC]/g, '').trim());
                    if (!isNaN(price)) exactSubtotal += price;
                }
            });
        } else {
            sidebarItems.forEach(item => {
                const priceTextElement = item.querySelector('.cart-item-price');
                if (priceTextElement) {
                    let priceText = priceTextElement.textContent || '0';
                    if (priceText.includes('×')) priceText = priceText.split('×')[1];
                    else if (priceText.includes('x')) priceText = priceText.split('x')[1];

                    const price = parseFloat(priceText.replace(/[$\u20AC]/g, '').trim());
                    if (!isNaN(price)) exactSubtotal += price;
                }
            });
        }

        const formattedTotal = formatToEuro(exactSubtotal);

        if (headerCartBadge) headerCartBadge.textContent = exactQty;
        if (headerCartTotal) headerCartTotal.textContent = formattedTotal;
        if (sidebarSubtotal) sidebarSubtotal.textContent = formattedTotal;

        const altCartBadge = document.querySelector('.cart-badge');
        if (altCartBadge) altCartBadge.textContent = exactQty;

        const altCartTotal = document.querySelector('.cart-total');
        if (altCartTotal) altCartTotal.textContent = formattedTotal;
    }

    // Вызываем при загрузке страницы
    globalHeaderSync();


    // ==========================================
    // 2. ДИНАМИЧЕСКИЕ МОДАЛЬНЫЕ ОКНА
    // ==========================================
    const addConfirmModalHtml = `
        <div id="addToCartConfirmModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:99999; justify-content:center; align-items:center; opacity:0; transition:opacity 0.25s ease; backdrop-filter:blur(4px); font-family:sans-serif;">
            <div id="addToCartConfirmBox" style="background:#fff; padding:30px; width:100%; max-width:420px; border-radius:12px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.15); transform:translateY(-20px); transition:transform 0.25s ease;">
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
        <div id="addToCartSuccessModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); z-index:999999; justify-content:center; align-items:center; opacity:0; transition:opacity 0.25s ease; backdrop-filter:blur(2px); font-family:sans-serif;">
            <div id="addToCartSuccessBox" style="background:#fff; padding:25px; width:100%; max-width:350px; border-radius:12px; text-align:center; box-shadow:0 10px 30px rgba(0,0,0,0.15); transform:translateY(-20px); transition:transform 0.25s ease;">
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
            setTimeout(() => {
                addModal.style.opacity = '1';
                addBox.style.transform = 'translateY(0)';
            }, 10);
        }
    }

    function closeAddModal() {
        if (addModal && addBox) {
            addModal.style.opacity = '0';
            addBox.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                addModal.style.display = 'none';
                currentProductIdToAdd = null;
            }, 250);
        }
    }

    function openSuccessModal() {
        if (successModal && successBox) {
            successModal.style.display = 'flex';
            setTimeout(() => {
                successModal.style.opacity = '1';
                successBox.style.transform = 'translateY(0)';
            }, 10);
            setTimeout(closeSuccessModal, 2000);
        }
    }

    function closeSuccessModal() {
        if (successModal && successBox) {
            successModal.style.opacity = '0';
            successBox.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                successModal.style.display = 'none';
            }, 250);
        }
    }

    if (addModalCancelBtn) addModalCancelBtn.addEventListener('click', closeAddModal);
    if (successModalCloseBtn) successModalCloseBtn.addEventListener('click', closeSuccessModal);

    if (addModal) {
        addModal.addEventListener('click', (e) => {
            if (e.target === addModal) closeAddModal();
        });
    }
    if (successModal) {
        successModal.addEventListener('click', (e) => {
            if (e.target === successModal) closeSuccessModal();
        });
    }

    document.body.addEventListener('click', function (e) {
        const btn = e.target.closest('.product-add-btn');
        if (btn) {
            e.preventDefault();
            e.stopPropagation();

            const productId = btn.getAttribute('data-id');
            if (!productId) return;

            const productCard = btn.closest('.product-card') ||
                btn.closest('.single-product-container') ||
                btn.closest('[class*="col-"]') ||
                btn.parentElement;

            let imgUrl = btn.getAttribute('data-img');
            if (!imgUrl && productCard) {
                const foundImg = productCard.querySelector('img');
                if (foundImg) imgUrl = foundImg.src;
            }

            let titleText = btn.getAttribute('data-title');
            if (!titleText && productCard) {
                const foundTitle = productCard.querySelector('.product-title') ||
                    productCard.querySelector('h1') ||
                    productCard.querySelector('h2') ||
                    productCard.querySelector('h3') ||
                    productCard.querySelector('h4');
                if (foundTitle) titleText = foundTitle.textContent.trim();
            }

            let priceText = btn.getAttribute('data-price');
            if (!priceText && productCard) {
                const foundPrice = productCard.querySelector('.product-price') ||
                    productCard.querySelector('.price') ||
                    productCard.querySelector('[class*="price"]');
                if (foundPrice) priceText = foundPrice.textContent.trim();
            }

            if (!titleText) titleText = "Картина";
            if (!priceText) priceText = "€0.00";

            openAddModal(productId, titleText, imgUrl, priceText);
        }
    });

    // Подтверждение добавления
    if (addModalSubmitBtn) {
        addModalSubmitBtn.addEventListener('click', function () {
            if (!currentProductIdToAdd) return;

            // --- МГНОВЕННОЕ ОБНОВЛЕНИЕ ИКОНКИ КОРЗИНЫ БЕЗ ЗАДЕРЖЕК ---
            let currentQty = parseInt(headerCartBadge ? headerCartBadge.textContent : '0') || 0;
            let currentSum = parseFloat(headerCartTotal ? headerCartTotal.textContent.replace(/[$\u20AC]/g, '').trim() : '0') || 0;

            let modalPriceText = addModalPrice.textContent || '0';
            if (modalPriceText.includes('×')) modalPriceText = modalPriceText.split('×')[1];
            else if (modalPriceText.includes('x')) modalPriceText = modalPriceText.split('x')[1];

            const targetPrice = parseFloat(modalPriceText.replace(/[$\u20AC]/g, '').trim()) || 0;

            let nextQty = currentQty + 1;
            let nextSum = currentSum + targetPrice;
            const formattedNextSum = formatToEuro(nextSum);

            // Записываем в шапку сайта значения МГНОВЕННО
            if (headerCartBadge) headerCartBadge.textContent = nextQty;
            if (headerCartTotal) headerCartTotal.textContent = formattedNextSum;

            const altCartBadge = document.querySelector('.cart-badge');
            if (altCartBadge) altCartBadge.textContent = nextQty;

            const altCartTotal = document.querySelector('.cart-total');
            if (altCartTotal) altCartTotal.textContent = formattedNextSum;

            if (sidebarItemsContainer) {
                if (sidebarItemsContainer.innerHTML.includes('Your cart is empty')) {
                    sidebarItemsContainer.innerHTML = '';
                }

                const existingSidebarItem = sidebarItemsContainer.querySelector(`[data-id="${currentProductIdToAdd}"]`);
                if (!existingSidebarItem) {
                    const cleanedPrice = formatToEuro(backupProductData.price);

                    // Убран текст "1 ×", оставлена только чистая цена
                    const newSidebarItemHtml = `
                        <div class="cart-sidebar-item" style="display:flex; align-items:center; justify-content:space-between; margin-bottom:15px; padding-bottom:15px; border-bottom:1px solid #eee;">
                            <div style="display:flex; align-items:center;">
                                <img src="${backupProductData.img || ''}" style="width:50px; height:50px; object-fit:cover; border-radius:4px; margin-right:10px;">
                                <div>
                                    <h5 style="margin:0; font-size:14px; font-weight:bold; color:#333;">${backupProductData.title}</h5>
                                    <span class="cart-item-price" style="font-size:13px; color:#666;">${cleanedPrice}</span>
                                </div>
                            </div>
                            <a href="#" class="cart-item-remove-sidebar" data-id="${currentProductIdToAdd}" style="color:#ff4d4f; font-weight:bold; text-decoration:none; margin-left:15px;">&times;</a>
                        </div>
                    `;
                    sidebarItemsContainer.insertAdjacentHTML('beforeend', newSidebarItemHtml);
                }

                if (sidebarSubtotal) {
                    sidebarSubtotal.textContent = formattedNextSum;
                }
            }

            closeAddModal();
            openSuccessModal();

            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": getCsrfToken()
                },
                body: JSON.stringify({ product_id: currentProductIdToAdd })
            })
                .then(response => response.json())
                .then(data => {
                    // Если сервер вернул успешный ответ, просто страхуемся, но глобальный пересчет
                    // больше не сбрасывает наши мгновенные значения назад.
                    if (data.success) {
                        // Не вызываем тут globalHeaderSync(), чтобы избежать секундного мерцания счетчиков
                    }
                })
                .catch(error => {
                    console.error('Ошибка добавления:', error);
                });
        });
    }


    // ==========================================
    // 3. УДАЛЕНИЕ ТОВАРОВ ИЗ СИСТЕМЫ САЙДБАРА
    // ==========================================
    if (sidebarItemsContainer) {
        sidebarItemsContainer.addEventListener('click', (e) => {
            const removeBtn = e.target.closest('.cart-item-remove-sidebar');
            if (removeBtn) {
                e.preventDefault();
                e.stopPropagation();

                const itemId = removeBtn.getAttribute('data-id');
                const cartItemRow = removeBtn.closest('.cart-sidebar-item');

                if (cartItemRow) {
                    cartItemRow.remove();
                }

                let newSubtotal = 0;
                let newTotalQty = 0;

                document.querySelectorAll('.cart-sidebar-content .cart-sidebar-item').forEach(item => {
                    const priceTextElement = item.querySelector('.cart-item-price');
                    if (priceTextElement) {
                        let priceText = priceTextElement.textContent || '0';
                        if (priceText.includes('×')) priceText = priceText.split('×')[1];
                        else if (priceText.includes('x')) priceText = priceText.split('x')[1];

                        const price = parseFloat(priceText.replace(/[$\u20AC]/g, '').trim());
                        if (!isNaN(price)) {
                            newSubtotal += price;
                        }
                    }
                    newTotalQty += 1;
                });

                const formattedSubtotal = formatToEuro(newSubtotal);

                if (sidebarSubtotal) sidebarSubtotal.textContent = formattedSubtotal;
                if (headerCartTotal) headerCartTotal.textContent = formattedSubtotal;
                if (headerCartBadge) headerCartBadge.textContent = newTotalQty;

                if (newTotalQty === 0) {
                    sidebarItemsContainer.innerHTML = '<div style="padding: 40px 20px; color: #999; text-align: center; font-size: 14px; font-family: sans-serif;">Your cart is empty</div>';
                }

                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({ cart_item_id: itemId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            globalHeaderSync();
                        }
                    })
                    .catch(error => {
                        console.error('Ошибка удаления:', error);
                    });
            }
        });
    }

    // ==========================================
    // 4. ПОЛНОЦЕННАЯ СТРАНИЦА КОРЗИНЫ (/cart)
    // ==========================================
    const cartWrapper = document.getElementById('cartProductsListWrapper');
    if (cartWrapper) {
        const removeUrl = cartWrapper.getAttribute('data-remove-url') || '/cart/remove';
        const csrfToken = cartWrapper.getAttribute('data-csrf');

        const deleteModal = document.getElementById('confirmDeleteModal');
        const deleteBox = document.getElementById('confirmDeleteBox');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const submitDeleteBtn = document.getElementById('submitDeleteBtn');

        let itemRowToDelete = null;
        let itemIdToDelete = null;

        function openDeleteModal(row, id) {
            itemRowToDelete = row;
            itemIdToDelete = id;
            if (deleteModal && deleteBox) {
                deleteModal.style.display = 'flex';
                setTimeout(() => {
                    deleteModal.style.opacity = '1';
                    deleteBox.style.transform = 'translateY(0)';
                }, 10);
            }
        }

        function closeDeleteModal() {
            if (deleteModal && deleteBox) {
                deleteModal.style.opacity = '0';
                deleteBox.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    deleteModal.style.display = 'none';
                    itemRowToDelete = null;
                    itemIdToDelete = null;
                }, 200);
            }
        }

        cartWrapper.addEventListener('click', function (e) {
            const removeBtn = e.target.closest('.remove-main-cart-btn');
            if (removeBtn) {
                e.preventDefault();
                e.stopPropagation();
                const itemRow = removeBtn.closest('.cart-item');
                const itemId = removeBtn.getAttribute('data-id');
                openDeleteModal(itemRow, itemId);
            }
        });

        if (submitDeleteBtn) {
            submitDeleteBtn.addEventListener('click', function () {
                if (!itemRowToDelete || !itemIdToDelete) return;

                itemRowToDelete.remove();
                const remainingItems = document.querySelectorAll('.cart-item');
                const remainingQty = remainingItems.length;

                let pageSubtotal = 0;
                remainingItems.forEach(row => {
                    const priceElement = row.querySelector('.cart-item-price-wrapper');
                    if (priceElement) {
                        const price = parseFloat(priceElement.textContent.replace(/[$\u20AC]/g, '').trim());
                        if (!isNaN(price)) pageSubtotal += price;
                    }
                });

                const finalPriceText = formatToEuro(pageSubtotal);

                const cartTotalSumElement = document.getElementById('cartTotalSum');
                if (cartTotalSumElement) cartTotalSumElement.textContent = finalPriceText;

                if (headerCartTotal) headerCartTotal.textContent = finalPriceText;
                if (headerCartBadge) headerCartBadge.textContent = remainingQty;

                closeDeleteModal();

                fetch(removeUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": csrfToken || getCsrfToken()
                    },
                    body: JSON.stringify({ cart_item_id: itemIdToDelete })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            globalHeaderSync();
                            if (remainingQty === 0) window.location.reload();
                        }
                    });
            });
        }

        if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', closeDeleteModal);
    }

    // ==========================================
    // 5. ОСТАЛЬНАЯ ЛОГИКА (ПЛЕЕР И ПОИСК)
    // ==========================================
    const videoWrapper = document.getElementById('customVideoPlayer');
    const video = document.getElementById('mainVideo');
    const playBtn = document.getElementById('videoPlayBtn');

    if (videoWrapper && video && playBtn) {
        function toggleVideo() {
            if (video.paused) {
                video.play();
                videoWrapper.classList.add('is-playing');
                video.setAttribute('controls', 'true');
            } else {
                video.pause();
                videoWrapper.classList.remove('is-playing');
            }
        }
        playBtn.addEventListener('click', toggleVideo);
        video.addEventListener('click', toggleVideo);
    }

    const searchTriggerBtn = document.getElementById('searchTriggerBtn');
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    if (searchTriggerBtn && searchInput && searchForm) {
        searchTriggerBtn.addEventListener('click', function (e) {
            if (searchInput.style.width === '0px' || searchInput.style.width === '') {
                e.preventDefault();
                searchInput.style.width = '180px';
                searchInput.style.opacity = '1';
                searchInput.style.paddingLeft = '10px';
                searchInput.style.paddingRight = '10px';
                searchInput.focus();
            } else if (searchInput.value.trim() !== '') {
                searchForm.submit();
            }
        });
    }
});
