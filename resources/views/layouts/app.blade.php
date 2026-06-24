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

<script src="{{ asset('js/cart-sidebar.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
