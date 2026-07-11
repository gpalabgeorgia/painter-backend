@extends('layouts.app')
@section('content')
    <!-- СЕКЦИЯ МАГАЗИНА (SHOP PAGE SECTION) -->
    <section class="shop-page-section">
        <div class="shop-container">
            <div class="shop-breadcrumbs">Home / Shop</div>
            <h1 class="shop-main-title">Shop</h1>

            <div class="shop-catalog-filter-bar">
                {{-- Изменено на total(), чтобы показывало общее количество товаров во всем магазине --}}
                <div class="catalog-results-count">Showing all {{ $products->total() }} results</div>
            </div>

            <div class="shop-products-grid">
                @forelse($products as $product)
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="{{ asset('img/products_img/' . $product->image) }}" alt="{{ $product->title }}" class="product-img">
                        </div>
                        <div class="product-info">
                            @if($product->subtitle)
                                <span class="product-category">{{ $product->subtitle }}</span>
                            @endif
                            <h4 class="product-title">{{ $product->title }}</h4>
                            <span class="product-price">{{ number_format($product->price, 2) }}€</span>
                            @auth('customer')
                                <!-- Если пользователь вошел — оставляем твою кнопку (добавление в корзину) -->
                                <a href="#" class="product-add-btn" data-id="{{ $product->id }}">ADD TO CART</a>
                            @else
                                <!-- Если гость — перенаправляем на страницу логина -->
                                <a href="{{ route('login') }}" class="product-add-btn" data-id="{{ $product->id }}">
                                    Add to cart
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                        <p>No paintings found in the shop yet.</p>
                    </div>
                @endforelse
            </div>

            {{-- КВАДРАТНАЯ ПАГИНАЦИЯ (КАК НА СТРАНИЦЕ ARTWORKS) --}}
            @if ($products->hasPages())
                <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 50px; margin-bottom: 20px;">

                    {{-- Кнопка "Назад" --}}
                    @if ($products->onFirstPage())
                        <span style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; background: #fff; color: #d1d5db; cursor: not-allowed; font-size: 14px;">&lsaquo;</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; background: #fff; color: #111827; text-decoration: none; font-size: 14px;">&lsaquo;</a>
                    @endif

                    {{-- Номера страниц --}}
                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if ($page == $products->currentPage())
                            {{-- Активная страница (Черный квадрат, белые цифры) --}}
                            <span style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #000; color: #fff; font-weight: 600; font-size: 14px;">{{ $page }}</span>
                        @else
                            {{-- Обычная страница (Белый квадрат, черные цифры) --}}
                            <a href="{{ $url }}" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; background: #fff; color: #111827; text-decoration: none; font-size: 14px;">{{ $page }}</a>
                        @endif
                    @endforeach

                    {{-- Кнопка "Вперед" --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; background: #fff; color: #111827; text-decoration: none; font-size: 14px;">&rsaquo;</a>
                    @else
                        <span style="display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; border: 1px solid #e5e7eb; background: #fff; color: #d1d5db; cursor: not-allowed; font-size: 14px;">&rsaquo;</span>
                    @endif

                </div>
            @endif

        </div>
    </section>
    @include('sections.subscribe')
@endsection
