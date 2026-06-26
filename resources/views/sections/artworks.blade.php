@if($artworks && $artworks->count() > 0)
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

            {{-- Сетка динамических карточек картин --}}
            <div class="artwork-grid">
                @foreach($artworks as $artwork)
                    <div class="artwork-card">

                        {{-- Контейнер изображения --}}
                        <div class="artwork-img-box">
                            @if(!empty($artwork->image))
                                <img src="{{ Storage::url($artwork->image) }}" alt="{{ $artwork->title }}">
                            @else
                                {{-- Заглушка на случай, если картинка не подгрузилась --}}
                                <img src="{{ asset('img/product-img-8-300x400.jpg') }}" alt="Placeholder">
                            @endif
                        </div>

                        {{-- Инфо-блок под картинкой --}}
                        <div class="artwork-info">
                            <span class="artwork-category">{{ $artwork->category }}</span>
                            <h3 class="artwork-title">{{ $artwork->title }}</h3>
                            <span class="artwork-price">${{ number_format($artwork->price, 2) }}</span>

                            <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif
