@php
    // Массив только для иконок соцсетей
    $socialIcons = [
        'instagram' => 'fa-brands fa-instagram',
        'facebook'  => 'fa-brands fa-facebook-f',
        'twitter'   => 'fa-brands fa-x-twitter',
        'telegram'  => 'fa-brands fa-telegram',
        'youtube'   => 'fa-brands fa-youtube',
        'tiktok'    => 'fa-brands fa-tiktok',
        'pinterest' => 'fa-brands fa-pinterest',
        'whatsapp'  => 'fa-brands fa-whatsapp',
        'linkedin'  => 'fa-brands fa-linkedin',
    ];
@endphp
<header class="site-header">
    <div class="container">
        <div class="header-top">

            <div class="header-contacts-block" style="display: flex; flex-direction: column; gap: 8px;">

                <div class="header-socials" style="display: flex; gap: 15px; align-items: center;">
                    @foreach($headerContacts as $contact)
                        @if(array_key_exists($contact->type, $socialIcons))
                            <a href="{{ $contact->value }}" class="social-link" target="_blank" title="{{ $contact->label ?? $contact->type }}">
                                <i class="{{ $socialIcons[$contact->type] }}"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
                @foreach($headerContacts as $contact)
                    @if($contact->type === 'phone')
                        <div class="header-phone-row">
                            <a href="tel:{{ $contact->value }}" style="font-size: 13px; text-decoration: none; color: #555; display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-phone" style="font-size: 11px;"></i> {{ $contact->value }}
                            </a>
                        </div>
                    @endif
                @endforeach
                @foreach($headerContacts as $contact)
                    @if($contact->type === 'email')
                        <div class="header-email-row">
                            <a href="mailto:{{ $contact->value }}" style="font-size: 13px; text-decoration: none; color: #555; display: flex; align-items: center; gap: 5px;">
                                <i class="fa-solid fa-envelope" style="font-size: 11px;"></i> {{ $contact->value }}
                            </a>
                        </div>
                    @endif
                @endforeach

            </div>
            <div class="header-logo">
                @if($logos && !empty($logos->header_logo))
                    <img src="{{ Storage::url($logos->header_logo) }}" alt="Zaza Papidze">
                @else
                    <h2>Zaza Papidze</h2>
                @endif
            </div>
            <div class="header-actions" style="display: flex; align-items: center; gap: 15px; position: relative;">

                <form action="{{ route('search') }}" method="GET" class="search-form" id="searchForm" style="display: flex; align-items: center; position: relative;">
                    <input type="text" name="query" id="searchInput" placeholder="Поиск по сайту..."
                           style="width: 0; opacity: 0; padding: 5px 0; border: none; border-bottom: 1px solid #333; outline: none; background: transparent; transition: all 0.4s ease; font-size: 14px;">
                    <button type="button" class="action-btn search-btn" id="searchTriggerBtn">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </form>

                <div class="header-cart">
                    @php
                        $customerId = Auth::guard('customer')->id();
                        $totalItems = 0;
                        $totalPrice = 0;

                        if ($customerId) {
                            $cartItems = \App\Models\CartItem::with('product')->where('customer_id', $customerId)->get();
                            $totalItems = $cartItems->sum('quantity');

                            foreach ($cartItems as $item) {
                                $totalPrice += ($item->product->price ?? 0) * $item->quantity;
                            }
                        }
                    @endphp

                        <!-- Теперь здесь гордый знак евро € -->
                    <span class="cart-total" id="openCartBtnText" style="cursor: pointer;">
                        €{{ number_format($totalPrice, 2, '.', '') }}
                    </span>

                    <a href="{{ route('cart.index') }}" class="cart-btn" id="openCartBtn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <path d="M16 10a4 4 0 0 1-8 0"></path>
                        </svg>
                        <span class="cart-badge">{{ $totalItems }}</span>
                    </a>
                </div>

                {{-- ЗОНА АВТОРИЗАЦИИ КЛИЕНТА --}}
                @auth('customer')
                    <div class="user-dropdown-wrapper" style="position: relative; display: inline-block;">
                        <button type="button" id="userMenuTriggerBtn" style="background: #333; color: #fff; border: 1px solid #ccc; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-family: inherit; transition: background 0.2s; padding: 0; overflow: hidden;">
                            @if(auth('customer')->user()->avatar)
                                <!-- Если есть аватарка, выводим её -->
                                <img src="{{ Storage::url(auth('customer')->user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                            @else
                                <!-- Если аватарки нет, показываем инициалы -->
                                <span style="font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ mb_substr(auth('customer')->user()->name, 0, 1) }}{{ mb_substr(auth('customer')->user()->last_name, 0, 1) }}
                </span>
                            @endif
                        </button>

                        <div id="userDropdownMenu" style="display: none; position: absolute; right: 0; top: calc(100% + 10px); background: #fff; min-width: 180px; box-shadow: 0px 8px 20px rgba(0,0,0,0.15); border: 1px solid #eee; border-radius: 4px; z-index: 1000; overflow: hidden;">
                            <a href="{{ url('/account') }}" style="color: #333; padding: 12px 16px; text-decoration: none; display: block; font-size: 14px; border-bottom: 1px solid #f5f5f5; transition: background 0.15s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                                Мой аккаунт
                            </a>
                            <a href="{{ url('/cart') }}" style="color: #333; padding: 12px 16px; text-decoration: none; display: block; font-size: 14px; border-bottom: 1px solid #f5f5f5; transition: background 0.15s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                                Мои покупки
                            </a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" style="color: #e74c3c; width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; cursor: pointer; font-family: inherit; font-size: 14px; font-weight: 500; transition: background 0.15s;" onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background='none'">
                                    Выход
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ url('/login') }}" class="action-btn user-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </a>
                @endauth

            </div>
        </div>

        <nav class="header-nav">
            <ul class="main-menu">
                @foreach($menuItems as $item)
                    <li>
                        <a href="{{ $item->url }}"
                           class="menu-item {{ request()->is(trim($item->url, '/')) ? 'active' : '' }}">
                            {{ $item->label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>

{{-- СКРИПТ АНИМАЦИИ ДЛЯ ВЫЕЗЖАЮЩЕГО ПОЛЯ ПОИСКА И ВЫПАДАЮЩЕГО МЕНЮ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Поиск
        const searchTriggerBtn = document.getElementById('searchTriggerBtn');
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');

        searchTriggerBtn.addEventListener('click', function (e) {
            if (searchInput.style.width === '0px' || searchInput.style.width === '') {
                e.preventDefault();
                searchInput.style.width = '180px';
                searchInput.style.opacity = '1';
                searchInput.style.paddingLeft = '10px';
                searchInput.style.paddingRight = '10px';
                searchInput.focus();
            } else {
                if (searchInput.value.trim() !== '') {
                    searchForm.submit();
                } else {
                    e.preventDefault();
                    searchInput.style.width = '0';
                    searchInput.style.opacity = '0';
                    searchInput.style.paddingLeft = '0';
                    searchInput.style.paddingRight = '0';
                }
            }
        });

        // Выпадающее меню профиля
        const userMenuTriggerBtn = document.getElementById('userMenuTriggerBtn');
        const userDropdownMenu = document.getElementById('userDropdownMenu');

        if (userMenuTriggerBtn && userDropdownMenu) {
            userMenuTriggerBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (userDropdownMenu.style.display === 'none' || userDropdownMenu.style.display === '') {
                    userDropdownMenu.style.display = 'block';
                } else {
                    userDropdownMenu.style.display = 'none';
                }
            });
        }

        // Глобальный клик для закрытия окон
        document.addEventListener('click', function (e) {
            // Закрытие поиска
            if (!searchForm.contains(e.target)) {
                searchInput.style.width = '0';
                searchInput.style.opacity = '0';
                searchInput.style.paddingLeft = '0';
                searchInput.style.paddingRight = '0';
            }
            // Закрытие меню пользователя
            if (userDropdownMenu && userMenuTriggerBtn && !userDropdownMenu.contains(e.target) && !userMenuTriggerBtn.contains(e.target)) {
                userDropdownMenu.style.display = 'none';
            }
        });
    });
</script>
