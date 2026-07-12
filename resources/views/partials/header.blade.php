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

                    <a href="{{ route('cart.index') }}" class="cart-btn" id="openCartBtn" style="display: inline-flex; align-items: center; gap: 10px; text-decoration: none;">

                    <span class="cart-total" id="openCartBtnText" style="cursor: pointer; margin-right: 2px;">
                        €{{ number_format($totalPrice, 2, '.', '') }}
                    </span>

                        <div style="position: relative; display: flex; align-items: center;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <span class="cart-badge">{{ $totalItems }}</span>
                        </div>

                    </a>
                </div>

                {{-- ЗОНА АВТОРИЗАЦИИ КЛИЕНТА --}}
                @auth('customer')
                    @php
                        // Заранее считаем количество непрочитанных сообщений
                        $unreadCount = auth('customer')->user()->notifications
                            ? auth('customer')->user()->notifications()->where('is_read', false)->count()
                            : 0;
                    @endphp

                    <div class="user-dropdown-wrapper" style="position: relative; display: inline-block;">

                        <!-- Кнопка профиля (аватарка) с индикатором поверх -->
                        <button type="button" id="userMenuTriggerBtn" style="background: #333; color: #fff; border: 1px solid #ccc; width: 34px; height: 34px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; font-family: inherit; transition: background 0.2s; padding: 0; position: relative;">

                            <!-- Контейнер для фото/инициалов, чтобы скрыть лишнее и сохранить круг -->
                            <div style="width: 100%; height: 100%; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                @if(auth('customer')->user()->avatar)
                                    <img src="{{ Storage::url(auth('customer')->user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                                @else
                                    <span style="font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">
                                        {{ mb_substr(auth('customer')->user()->name, 0, 1) }}{{ mb_substr(auth('customer')->user()->last_name, 0, 1) }}
                                    </span>
                                @endif
                            </div>

                            <!-- Счетчик поверх аватарки (справа вверху) -->
                            @if($unreadCount > 0)
                                <span style="position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; border-radius: 9999px; width: 16px; height: 16px; font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center; line-height: 1; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 10;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>

                        <!-- Раскрывающийся список -->
                        <div id="userDropdownMenu" style="display: none; position: absolute; right: 0; top: calc(100% + 10px); background: #fff; min-width: 180px; box-shadow: 0px 8px 20px rgba(0,0,0,0.15); border: 1px solid #eee; border-radius: 4px; z-index: 1000; overflow: hidden;">
                            <a href="{{ url('/account') }}" style="color: #333; padding: 12px 16px; text-decoration: none; display: block; font-size: 14px; border-bottom: 1px solid #f5f5f5; transition: background 0.15s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                                Мой аккаунт
                            </a>

                            <!-- Пункт «Мои сообщения» со счетчиком справа -->
                            <a href="{{ url('/account/messages') }}" style="color: #333; padding: 12px 16px; text-decoration: none; display: flex; align-items: center; justify-content: space-between; font-size: 14px; border-bottom: 1px solid #f5f5f5; transition: background 0.15s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='none'">
                                <span>Мои сообщения</span>
                                @if($unreadCount > 0)
                                    <span style="background: #ef4444; color: white; border-radius: 9999px; padding: 2px 7px; font-size: 11px; font-weight: bold; line-height: 1;">
                                        {{ $unreadCount }}
                                    </span>
                                @endif
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

                {{-- ВЫПАДАЮЩИЙ СПИСОК ЯЗЫКОВ --}}
                <div class="lang-dropdown-wrapper" style="position: relative; display: inline-block;">
                    <button type="button" id="langMenuTriggerBtn" class="action-btn" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 4px; padding: 0; color: currentColor;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                        <span style="font-size: 12px; font-weight: bold; text-transform: uppercase;">{{ session('locale', 'es') }}</span>
                    </button>

                    <div id="langDropdownMenu" style="display: none; position: absolute; right: 0; top: calc(100% + 17px); background: #fff; min-width: 140px; box-shadow: 0px 8px 20px rgba(0,0,0,0.15); border: 1px solid #eee; border-radius: 4px; z-index: 1000; overflow: hidden;">
                        @foreach(\App\Models\Language::where('is_active', true)->get() as $lang)
                            <a href="{{ route('lang.switch', $lang->code) }}"
                               style="color: #333; padding: 10px 14px; text-decoration: none; display: block; font-size: 13px; transition: background 0.15s; {{ session('locale', 'es') == $lang->code ? 'background: #f5f5f5; font-weight: bold; color: #e67e22;' : '' }}"
                               onmouseover="this.style.background='#f9f9f9'"
                               onmouseout="this.style.background='{{ session('locale', 'es') == $lang->code ? '#f5f5f5' : 'none' }}'">
                                {{ $lang->name }} ({{ strtoupper($lang->code) }})
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <nav class="header-nav">
            <ul class="main-menu">
                @foreach($menuItems as $item)
                    <li>
                        <a href="{{ $item->url }}"
                           class="menu-item {{ request()->is(trim($item->url, '/')) ? 'active' : '' }}">
                            {{ \App\Http\Controllers\Front\LanguageController::trans($item->label) }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</header>

{{-- СКРИПТ АНИМАЦИИ ДЛЯ ВЫЕЗЖАЮЩЕГО ПОЛЯ ПОИСКА И ВЫПАДАЮЩИХ МЕНЮ --}}
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
                // Закрываем меню языков, если открыто
                if (langDropdownMenu) langDropdownMenu.style.display = 'none';

                if (userDropdownMenu.style.display === 'none' || userDropdownMenu.style.display === '') {
                    userDropdownMenu.style.display = 'block';
                } else {
                    userDropdownMenu.style.display = 'none';
                }
            });
        }

        // Выпадающее меню языков
        const langMenuTriggerBtn = document.getElementById('langMenuTriggerBtn');
        const langDropdownMenu = document.getElementById('langDropdownMenu');

        if (langMenuTriggerBtn && langDropdownMenu) {
            langMenuTriggerBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                // Закрываем меню юзера, если открыто
                if (userDropdownMenu) userDropdownMenu.style.display = 'none';

                if (langDropdownMenu.style.display === 'none' || langDropdownMenu.style.display === '') {
                    langDropdownMenu.style.display = 'block';
                } else {
                    langDropdownMenu.style.display = 'none';
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
            // Закрытие меню языков
            if (langDropdownMenu && langMenuTriggerBtn && !langDropdownMenu.contains(e.target) && !langMenuTriggerBtn.contains(e.target)) {
                langDropdownMenu.style.display = 'none';
            }
        });
    });

    // Настройка прослушивания WebSocket
    if (window.Echo) {
        // Получаем ID текущего авторизованного кастомера из мета-тега или глобальной переменной
        const customerId = "{{ auth('customer')->id() }}";

        if (customerId) {
            window.Echo.private('customer.' + customerId)
                .listen('NotificationReceived', (e) => {
                    // e.unreadCount вернет точную цифру непрочитанных
                    const count = e.unreadCount;

                    // Находим или создаем бейдж на аватарке
                    let avatarBadge = document.querySelector('#userMenuTriggerBtn span[style*="background: rgb(239, 68, 68)"]') || document.querySelector('#userMenuTriggerBtn span[style*="background: #ef4444"]');
                    if (!avatarBadge && count > 0) {
                        // Если бейджа нет, динамически создаем его
                        avatarBadge = document.createElement('span');
                        avatarBadge.style = "position: absolute; top: -4px; right: -4px; background: #ef4444; color: white; border-radius: 9999px; width: 16px; height: 16px; font-size: 10px; font-weight: bold; display: flex; align-items: center; justify-content: center; line-height: 1; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); z-index: 10;";
                        document.getElementById('userMenuTriggerBtn').appendChild(avatarBadge);
                    }

                    // Находим или создаем бейдж внутри выпадающего списка у пункта "Мои сообщения"
                    let menuLink = document.querySelector('a[href*="/account/messages"]');
                    let menuBadge = menuLink.querySelector('span[style*="background"]');
                    if (!menuBadge && count > 0) {
                        menuBadge = document.createElement('span');
                        menuBadge.style = "background: #ef4444; color: white; border-radius: 9999px; padding: 2px 7px; font-size: 11px; font-weight: bold; line-height: 1;";
                        menuLink.appendChild(menuBadge);
                    }

                    if (count > 0) {
                        avatarBadge.innerText = count;
                        avatarBadge.style.display = 'flex';
                        menuBadge.innerText = count;
                        menuBadge.style.display = 'inline-block';
                    } else {
                        if (avatarBadge) avatarBadge.style.display = 'none';
                        if (menuBadge) menuBadge.style.display = 'none';
                    }
                });
        }
    }
</script>
