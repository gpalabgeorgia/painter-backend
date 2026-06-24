@if($hero && $hero->is_active)
    <section class="hero-section">
        <div class="container hero-container">

            <div class="hero-col hero-left">
                {{-- Выводим заголовок, заменяя обычные переносы строк на теги <br> --}}
                <h1 class="hero-title">{!! nl2br(e($hero->left_title)) !!}</h1>
                <p class="hero-subtitle">
                    {!! nl2br(e($hero->left_text_1)) !!}<br>
                    {!! nl2br(e($hero->left_text_2)) !!}
                </p>
            </div>

            <div class="hero-col hero-center">
                <div class="painting-block">
                    <div class="painting-frame">
                        @if($hero->center_image)
                            {{-- Картинка теперь берется напрямую из public/hero/... --}}
                            <img src="{{ asset($hero->center_image) }}" alt="Abstract Painting by {{ $hero->left_title }}">
                        @else
                            {{-- Твоя дефолтная заглушка --}}
                            <img src="{{ asset('img/painter-artist-portfolio-hero-img.jpg') }}" alt="Default Painting">
                        @endif
                    </div>

                    <a href="#" class="explore-more">
                        EXPLORE MORE
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                </div>
            </div>

            <div class="hero-col hero-right">
                <div class="hero-divider"></div>
                <p class="hero-text">
                    {{ $hero->right_small_text }}
                </p>
            </div>

        </div>
    </section>
@endif
