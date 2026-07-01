    <section class="artwork-section">
        <div class="artwork-container">
            {{-- Динамическая шапка секции с заголовком и подзаголовком из админки --}}
            <div class="artwork-header">
                <div class="artwork-header-left">
                    <h2>{{ $artworkHeader->title ?? 'Latest artwork' }}</h2>
                    <p>{{ $artworkHeader->subtitle ?? 'Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.' }}</p>
                </div>
                <div class="artwork-header-right">
                    <a href="#" class="view-all-btn">VIEW ALL <span>&rarr;</span></a>
                </div>
            </div>
            <div class="shop-products-grid">
                @forelse($featuredProducts as $product)
                    <div class="product-card">
                        <div class="product-img-box">
                            <img src="{{ asset('img/products_img/' . $product->image) }}" alt="{{ $product->title }}" class="product-img">
                        </div>
                        <div class="product-info">
                            @if($product->subtitle)
                                <span class="product-category">{{ $product->subtitle }}</span>
                            @endif
                            <h4 class="product-title">{{ $product->title }}</h4>
                            <span class="product-price">€{{ number_format($product->price, 2, '.', ' ') }}</span>
                            <a href="#" class="product-add-btn">ADD TO CART</a>
                        </div>
                    </div>
                @empty
                    <div class="no-products" style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #666;">
                        <p>No recent paintings found.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </section>

