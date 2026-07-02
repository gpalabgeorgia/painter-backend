<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>
<body>
    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- ПОЛУПРОЗРАЧНЫЙ ФОН ПРИ ОТКРЫТИИ КОРЗИНЫ -->
    <div class="cart-sidebar-overlay" id="cartOverlay"></div>
    <!-- ВЫДВИЖНОЙ САЙДБАР КОРЗИНЫ -->
    @include('partials.cartSidebar')

    <!-- Модальное окно активации -->
    @if(session('account_activated'))
        <div id="activationModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: flex; align-items: center; justify-content: center; z-index: 9999;">
            <div style="background: #fff; padding: 30px; max-width: 450px; width: 90%; text-align: center; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); position: relative;">

                <h3 style="margin-top: 0; color: #2ecc71; font-size: 22px;">Успешно!</h3>
                <p style="color: #333; font-size: 16px; line-height: 1.5; margin: 15px 0 25px 0;">
                    Ваш аккаунт успешно активирован. Зайдите в вашу учетную запись.
                </p>

                <button onclick="closeActivationModal()" style="background: #000; color: #fff; border: none; padding: 12px 30px; font-size: 14px; cursor: pointer; font-weight: bold; width: 100%; border-radius: 4px;">
                    ОК
                </button>
            </div>
        </div>

        <script>
            function closeActivationModal() {
                document.getElementById('activationModal').style.display = 'none';
                // Опционально: можно сразу перенаправить на страницу логина
                window.location.href = "{{ url('/login') }}";
            }
        </script>
    @endif

    <!-- Дополнительно: Обычное уведомление о том, что надо проверить почту после регистрации -->
    @if(session('info'))
        <div style="position: fixed; bottom: 20px; right: 20px; background: #3498db; color: #fff; padding: 15px 25px; border-radius: 4px; z-index: 9999; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            {{ session('info') }}
        </div>
    @endif

<script src="{{ asset('js/cart-sidebar.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
