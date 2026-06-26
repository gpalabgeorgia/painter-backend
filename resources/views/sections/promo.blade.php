@if($promo)
    <section class="learn-section">
        <div class="container">
            <div class="learn-card-box">

                {{-- Декоративный фоновый градиент --}}
                <img src="{{ asset('img/gradient-line-bg-3.svg') }}" alt="Background shape" class="learn-blob">

                {{-- Левая часть: Изображение художника --}}
                <div class="learn-image-wrapper">
                    @if(!empty($promo->image))
                        <img src="{{ Storage::url($promo->image) }}" alt="{{ $promo->title }}">
                    @else
                        <img src="{{ asset('img/learn-painting-cta.png') }}" alt="Painter with brush">
                    @endif
                </div>

                {{-- Правая часть: Контент из админки --}}
                <div class="learn-text-content">
                    <h2 class="learn-title">{{ $promo->title }}</h2>
                    <p class="learn-descr">{{ $promo->description }}</p>

                    {{-- Кнопка со ссылкой --}}
                    <a href="{{ $promo->button_url ?? '#' }}" class="learn-btn">
                        {{ $promo->button_text }}
                    </a>
                </div>

            </div>
        </div>
    </section>
@endif
