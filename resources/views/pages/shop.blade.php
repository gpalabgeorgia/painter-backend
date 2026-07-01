@extends('layouts.app')
@section('content')
    <!-- СЕКЦИЯ МАГАЗИНА (SHOP PAGE SECTION) -->
    <section class="shop-page-section">
            <div class="shop-container">
                <div class="shop-breadcrumbs">Home / Shop</div>
                <h1 class="shop-main-title">Shop</h1>

                <div class="shop-catalog-filter-bar">
                    <div class="catalog-results-count">Showing all {{ $products->count() }} results</div>
                    <div class="catalog-sorting-wrapper">
                        <select class="catalog-sort-select">
                            <option value="default">Default sorting</option>
                            <option value="popularity">Sort by popularity</option>
                            <option value="rating">Sort by average rating</option>
                            <option value="latest">Sort by latest</option>
                            <option value="price-low">Sort by price: low to high</option>
                            <option value="price-high">Sort by price: high to low</option>
                        </select>
                    </div>
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
                                <a href="#" class="product-add-btn">ADD TO CART</a>
                            </div>
                        </div>
                    @empty
                        <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                            <p>No paintings found in the shop yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @include('sections.subscribe')
@endsection
