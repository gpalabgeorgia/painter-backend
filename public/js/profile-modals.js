document.addEventListener('DOMContentLoaded', function () {
    // Модалка ошибки (единственный адрес)
    const warningModal = document.getElementById('addressWarningModal');
    const warningBox = document.getElementById('addressWarningBox');
    const closeWarningBtn = document.getElementById('closeAddressWarningBtn');

    // Модалка добавления адреса
    const addModal = document.getElementById('addAddressModal');
    const addBox = document.getElementById('addAddressBox');
    const openAddBtn = document.getElementById('openAddAddressModal');
    const closeAddBtn = document.getElementById('closeAddAddressModal');
    const cancelAddBtn = document.getElementById('cancelAddAddress');

    // Модалка подтверждения удаления
    const confirmModal = document.getElementById('confirmDeleteModal');
    const confirmBox = document.getElementById('confirmDeleteBox');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const submitDeleteBtn = document.getElementById('submitDeleteBtn');

    // Временные переменные для удаления
    let addressIdToDelete = null;
    let isMainToDelete = false;

    function openModal(modal, box) {
        if (modal && box) {
            modal.style.display = 'flex';
            setTimeout(() => {
                modal.style.opacity = '1';
                box.style.transform = 'translateY(0)';
            }, 10);
        }
    }

    function closeModal(modal, box) {
        if (modal && box) {
            modal.style.opacity = '0';
            box.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }

    if (openAddBtn) openAddBtn.addEventListener('click', () => openModal(addModal, addBox));
    if (closeAddBtn) closeAddBtn.addEventListener('click', () => closeModal(addModal, addBox));
    if (cancelAddBtn) cancelAddBtn.addEventListener('click', () => closeModal(addModal, addBox));
    if (closeWarningBtn) closeWarningBtn.addEventListener('click', () => closeModal(warningModal, warningBox));
    if (cancelDeleteBtn) cancelDeleteBtn.addEventListener('click', () => closeModal(confirmModal, confirmBox));

    // Закрытие по клику вне окон
    window.addEventListener('click', function(e) {
        if (e.target === addModal) closeModal(addModal, addBox);
        if (e.target === warningModal) closeModal(warningModal, warningBox);
        if (e.target === confirmModal) closeModal(confirmModal, confirmBox);
    });

    // КЛИК ПО ИКОНКЕ КОРЗИНЫ
    document.body.addEventListener('click', function (e) {
        const deleteBtn = e.target.closest('.delete-address-btn');
        if (!deleteBtn) return;

        e.preventDefault();

        // Считаем общее количество адресов
        const totalAddressesCount = document.querySelectorAll('.delete-address-btn').length;

        // Если остался всего один адрес — блокируем и выводим ошибку
        if (totalAddressesCount <= 1) {
            openModal(warningModal, warningBox);
            return;
        }

        // Если адресов больше одного — открываем кастомное окно подтверждения
        addressIdToDelete = deleteBtn.getAttribute('data-id');
        isMainToDelete = deleteBtn.getAttribute('data-is-main') === 'true';

        openModal(confirmModal, confirmBox);
    });

    // КЛИК «ДА, УДAЛИТЬ» В МОДАЛКЕ
    if (submitDeleteBtn) {
        submitDeleteBtn.addEventListener('click', function() {
            if (isMainToDelete) {
                // Очистка полей основного профиля, если удаляется "Основной" адрес
                // Через JS находим поля в форме 1 и очищаем их на бэкенде
                const form = document.querySelector('form[action*="update-info"]');
                if (form) {
                    // Создаем скрытые инпуты для очистки адреса в профиле
                    const clearInputs = ['address', 'city', 'region', 'zip_code', 'country'];
                    clearInputs.forEach(fieldName => {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = fieldName;
                        hiddenInput.value = '';
                        form.appendChild(hiddenInput);
                    });
                    form.submit();
                }
            } else if (addressIdToDelete) {
                // Стандартное удаление из дополнительной таблицы customer_addresses
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/account/addresses/${addressIdToDelete}`;

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
                form.innerHTML = `
                            <input type="hidden" name="_token" value="${csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                        `;

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
});
