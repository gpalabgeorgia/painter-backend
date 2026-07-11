@extends('layouts.app')
@section('content')
    <section class="checkout-page-section">
        <div class="checkout-container">
            <div class="checkout-addresses-section" style="margin-bottom: 25px; background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
                <h4 style="margin-top: 0; margin-bottom: 15px; font-size: 16px; font-weight: 600; display: flex; align-items: center; gap: 8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="2">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    Select Shipping Address
                </h4>

                <div class="address-radio-grid" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 15px;">

                    <label class="address-radio-label" style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 12px; border-radius: 6px; border: 1px solid #ddd; cursor: pointer;">
                        <input type="radio" name="selected_address_id" value="main" checked style="margin-top: 4px;">
                        <div>
                            <strong style="font-size: 14px;">Main Address (Default)</strong>
                            <p style="margin: 4px 0 0 0; font-size: 13px; color: #555;">
                                {{ $customer->address }}, {{ $customer->city }}, {{ $customer->region }}, {{ $customer->zip_code }}, {{ $customer->country }}
                            </p>
                        </div>
                    </label>

                    @if($customer->addresses && $customer->addresses->count() > 0)
                        @foreach($customer->addresses as $address)
                            <label class="address-radio-label" style="display: flex; align-items: flex-start; gap: 10px; background: #fff; padding: 12px; border-radius: 6px; border: 1px solid #ddd; cursor: pointer;">
                                <input type="radio" name="selected_address_id" value="{{ $address->id }}" style="margin-top: 4px;">
                                <div>
                                    <strong style="font-size: 14px;">{{ $address->first_name }} {{ $address->last_name }}</strong>
                                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #555;">
                                        {{ $address->address }}, {{ $address->city }}, {{ $address->region }}, {{ $address->zip_code }}, {{ $address->country }}
                                    </p>
                                </div>
                            </label>
                        @endforeach
                    @endif

                </div>

                <button type="button" id="openAddAddressModal" class="btn-add-address" style="background: none; border: 1px dashed #1a1a1a; padding: 8px 16px; border-radius: 4px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #1a1a1a; transition: all 0.2s;">
                    <span>+ Add new address</span>
                </button>
            </div>
            <div class="checkout-grid">
                <form id="checkoutForm" onsubmit="event.preventDefault();">
                    <div class="billing-details">
                        <h3>Billing details</h3>
                        <div class="form-row-split">
                            <div class="form-group">
                                <label>First name<span class="required-star">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $customer->name ?? '') }}" class="checkout-input" required>
                            </div>
                            <div class="form-group">
                                <label>Last name<span class="required-star">*</span></label>
                                <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name ?? '') }}" class="checkout-input" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Country / Region<span class="required-star">*</span></label>

                            @if(!empty($customer->country))
                                <input type="text" class="checkout-input" value="{{ $customer->country }}" readonly style="background-color: #f8f9fa; color: #6c757d; cursor: not-allowed;">

                                <input type="hidden" name="country" value="{{ $customer->country }}">
                            @else
                                <input type="text" name="country" value="{{ old('country') }}" class="checkout-input" placeholder="e.g. Spain" required>
                            @endif
                        </div>

                        <div class="form-group" style="margin-bottom: 10px;">
                            <label>Street address<span class="required-star">*</span></label>
                            <input type="text" name="address" value="{{ old('address', $customer->address ?? '') }}" class="checkout-input" placeholder="House number and street name" required>
                        </div>

                        <div class="form-group">
                            <label>Town / City<span class="required-star">*</span></label>
                            <input type="text" name="city" value="{{ old('city', $customer->city ?? '') }}" class="checkout-input" required>
                        </div>

                        <div class="form-group">
                            <label>State<span class="required-star">*</span></label>
                            <input type="text" name="region" value="{{ old('region', $customer->region ?? '') }}" class="checkout-input" placeholder="State / Region" required>
                        </div>

                        <div class="form-group">
                            <label>ZIP Code<span class="required-star">*</span></label>
                            <input type="text" name="zip_code" value="{{ old('zip_code', $customer->zip_code ?? '') }}" class="checkout-input" required>
                        </div>

                        <div class="form-group">
                            <label>Phone<span class="required-star">(optional)</span></label>
                            <input type="tel" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" class="checkout-input">
                        </div>

                        <div class="form-group">
                            <label>Email address<span class="required-star">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $customer->email ?? '') }}" class="checkout-input" required>
                        </div>
                    </div>
                </form>
                <div class="order-review-box">
                    <h3>Your order</h3>
                    <table class="order-table">
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody id="checkoutOrderItems">
                        </tbody>
                        <tfoot>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-right total-row-bold" id="checkoutSubtotal">$0.00</td>
                        </tr>
                        <tr>
                            <td style="border-bottom: none;">Total</td>
                            <td class="text-right total-row-bold" id="checkoutTotal" style="border-bottom: none; font-size: 16px;">$0.00</td>
                        </tr>
                        </tfoot>
                    </table>

                    <div class="payment-methods-notice">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666666" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="9"></line><line x1="9" y1="13" x2="15" y2="13"></line><line x1="9" y1="17" x2="15" y2="17"></line></svg>
                        <span>Sorry, it seems that there are no available payment methods. Please contact us if you require assistance or wish to make alternate arrangements.</span>
                    </div>
                    <button type="submit" form="checkoutForm" class="btn-place-order">PLACE ORDER</button>
                </div>
            </div>
        </div>
    </section>

    <div id="addAddressModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); justify-content: center; align-items: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;">
        <div id="addAddressBox" style="background: #fff; padding: 30px; border-radius: 8px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: translateY(-20px); transition: transform 0.3s ease; font-family: inherit;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h3 style="margin: 0; font-size: 20px; color: #333; font-weight: 600;">Add new shipping address</h3>
                <button type="button" id="closeAddAddressModal" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999; line-height: 1; padding: 0;">&times;</button>
            </div>

            <form action="{{ route('account.addresses.store') }}" method="POST">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">First name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', auth()->guard('customer')->user()->name ?? '') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Last name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', auth()->guard('customer')->user()->last_name ?? '') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Email address *</label>
                        <input type="email" name="email" value="{{ old('email', auth()->guard('customer')->user()->email ?? '') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Phone number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Country *</label>
                        <input type="text" name="country" value="{{ old('country') }}" placeholder="e.g. Spain" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">State / Region</label>
                        <input type="text" name="region" value="{{ old('region') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Town / City *</label>
                        <input type="text" name="city" value="{{ old('city') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">ZIP Code *</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Street address *</label>
                    <textarea name="address" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; box-sizing: border-box;" required>{{ old('address') }}</textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                    <button type="button" id="cancelAddAddress" style="background: #fff; color: #333; border: 1px solid #ccc; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px;">Cancel</button>
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px;">Save Address</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Модальное окно успешного заказа -->
    <div id="orderSuccessModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); justify-content: center; align-items: center; z-index: 10000; opacity: 0; transition: opacity 0.3s ease;">
        <div id="orderSuccessBox" style="background: #fff; padding: 40px; border-radius: 8px; max-width: 450px; width: 100%; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.2); transform: translateY(-30px); transition: transform 0.3s ease;">
            <div style="width: 60px; height: 60px; background: #e6f7ed; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h3 style="margin: 0 0 10px 0; font-size: 22px; font-weight: 600; color: #1a1a1a;">Thank You!</h3>
            <p style="margin: 0 0 25px 0; font-size: 15px; color: #666; line-height: 1.5;">Your order has been placed successfully.</p>
            <div style="font-size: 13px; color: #999;">Redirecting to home page...</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Элементы таблицы заказа
            const orderItemsContainer = document.getElementById('checkoutOrderItems');
            const subtotalContainer = document.getElementById('checkoutSubtotal');
            const totalContainer = document.getElementById('checkoutTotal');
            const checkoutForm = document.getElementById('checkoutForm');

            // Элементы модалки добавления адреса
            const addModal = document.getElementById('addAddressModal');
            const addBox = document.getElementById('addAddressBox');
            const openAddBtn = document.getElementById('openAddAddressModal');
            const closeAddBtn = document.getElementById('closeAddAddressModal');
            const cancelAddBtn = document.getElementById('cancelAddAddress');

            // Функции модального окна
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

            // Слушатели для модалки адреса
            if (openAddBtn) openAddBtn.addEventListener('click', () => openModal(addModal, addBox));
            if (closeAddBtn) closeAddBtn.addEventListener('click', () => closeModal(addModal, addBox));
            if (cancelAddBtn) cancelAddBtn.addEventListener('click', () => closeModal(addModal, addBox));

            window.addEventListener('click', function(e) {
                if (e.target === addModal) closeModal(addModal, addBox);
            });

            // 1. Загрузка данных корзины при старте страницы
            if (orderItemsContainer) {
                fetch('/cart/data', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Failed to load cart data');
                        return response.json();
                    })
                    .then(data => {
                        orderItemsContainer.innerHTML = '';

                        if (data.items.length === 0) {
                            orderItemsContainer.innerHTML = `
                    <tr>
                        <td colspan="2" class="text-center" style="color: #999; padding: 20px 0;">Your cart is empty</td>
                    </tr>
                `;
                            subtotalContainer.textContent = '€0.00';
                            totalContainer.textContent = '€0.00';
                            return;
                        }

                        // Рендерим продукты без количества
                        data.items.forEach(item => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                    <td>${item.title}</td>
                    <td class="text-right">€${Number(item.price).toFixed(2)}</td>
                `;
                            orderItemsContainer.appendChild(tr);
                        });

                        const formattedTotal = '€' + Number(data.total).toFixed(2);
                        subtotalContainer.textContent = formattedTotal;
                        totalContainer.textContent = formattedTotal;
                    })
                    .catch(error => {
                        console.error('Error fetching order review:', error);
                        orderItemsContainer.innerHTML = '<tr><td colspan="2" class="text-danger">Error loading order items</td></tr>';
                    });
            }

            // 2. Обработка клика на PLACE ORDER и отправка заказа
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const formData = new FormData(checkoutForm);

                    const notesTextarea = document.querySelector('.checkout-textarea');
                    if (notesTextarea) {
                        formData.append('notes', notesTextarea.value);
                    }

                    fetch('{{ route("checkout.store") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Находим элементы новой модалки
                                const successModal = document.getElementById('orderSuccessModal');
                                const successBox = document.getElementById('orderSuccessBox');

                                if (successModal && successBox) {
                                    successModal.style.display = 'flex';
                                    setTimeout(() => {
                                        successModal.style.opacity = '1';
                                        successBox.style.transform = 'translateY(0)';
                                    }, 10);

                                    // Ждем 2.5 секунды, чтобы пользователь порадовался покупке, и редиректим
                                    setTimeout(() => {
                                        window.location.href = data.redirect;
                                    }, 2500);
                                } else {
                                    window.location.href = data.redirect;
                                }
                            } else {
                                alert(data.message || 'Something went wrong');
                            }
                        })
                        .catch(error => {
                            console.error('Error creating order:', error);
                            alert('An error occurred while placing the order.');
                        });
                });
            }
        });
    </script>
@endsection
