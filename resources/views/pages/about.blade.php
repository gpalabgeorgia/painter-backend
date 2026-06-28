@extends('layouts.app')
@section('content')
    <!-- СЕКЦИЯ ABOUT HERO (ДИНАМИЧЕСКАЯ) -->
    @if($aboutData)
        <section class="about-hero-section">
            <div class="about-hero-container">
                <!-- Верхняя декоративная черточка -->
                <div class="about-top-line"></div>
                <!-- Главный заголовок страницы (из админки) -->
                <h1 class="about-main-title">{{ $aboutData->s1_title ?? 'About' }}</h1>
                <!-- Центральное изображение процесса (из админки) -->
                @if($aboutData->s1_image)
                    <div class="about-image-box">
                        <img src="{{ Storage::url($aboutData->s1_image) }}" alt="{{ $aboutData->s1_subtitle ?? 'The miraculous process' }}">
                    </div>
                @endif
                <!-- Текстовый блок под картинкой -->
                <div class="about-content-box">
                    <!-- Заголовок текста (из админки) -->
                    <h2 class="about-subtitle">{{ $aboutData->s1_subtitle ?? 'The miraculous process' }}</h2>

                    <!-- Сам текст из RichEditor (из админки) -->
                    <div class="about-text">
                        {!! $aboutData->s1_text !!}
                    </div>
                </div>
            </div>
        </section>
    @else
        <!-- Фуллбэк на случай, если в базе пусто, хотя мы её защитили -->
        <section class="about-hero-section">
            <div class="about-hero-container">
                <div class="about-top-line"></div>
                <h1 class="about-main-title">About</h1>
                <div class="about-content-box">
                    <p>Пожалуйста, заполните первую секцию в админке.</p>
                </div>
            </div>
        </section>
    @endif

    <!-- СЕКЦИЯ С ЦИТАТОЙ (ПОКА СТАТИКА) -->
    <section class="artist-quote-section">
        <div class="artist-quote-container">
            <div class="artist-image-wrapper">
                <img src="{{ asset('img/gradient-line-bg-3.svg') }}" alt="" class="quote-blob">
                <div class="artist-photo-box">
                    <img src="{{ asset('img/about-painter-img2.jpg') }}" alt="John Alwin">
                </div>
            </div>
            <div class="artist-info-wrapper">
                <div class="quote-icon">
                    <svg width="46" height="34" viewBox="0 0 60 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 16C16 23 12 33 4 38L0 34C5 29 7 24 7 19H0V4C0 1.8 1.8 0 4 0H12C14.2 0 16 1.8 16 4V16Z" fill="#2fd1dc"/>
                        <circle cx="8" cy="11" r="8" fill="#2fd1dc"/>
                        <path d="M46 16C46 23 42 33 34 38L30 34C35 29 37 24 37 19H30V4C30 1.8 31.8 0 34 0H42C44.2 0 46 1.8 46 4V16Z" fill="#2fd1dc"/>
                        <circle cx="38" cy="11" r="8" fill="#2fd1dc"/>
                    </svg>
                </div>
                <blockquote class="artist-blockquote">
                    The energy I put into aliquet cursus er integer urna, vestibulum cras bibendum diam sem eros amet malesuada.
                </blockquote>
                <div class="artist-signature-box">
                    <img src="{{ asset('img/signature.svg') }}" alt="Zaza Papidze Signature" class="artist-signature">
                </div>
                <span class="artist-name">Zaza Papidze</span>
            </div>
        </div>
    </section>

    <!-- СЕКЦИЯ НАГРАД И СТАТИСТИКИ (ПОКА СТАТИКА) -->
    <section class="awards-section">
        <div class="awards-container">
            <h2 class="awards-title">Awards</h2>
            <div class="awards-logos-grid">
                <div class="awards-logos-row row-top">
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-1.svg') }}" alt="Logoipsum"></div>
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-2.svg') }}" alt="Ultimate Winner"></div>
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-3.svg') }}" alt="Power XR2"></div>
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-4.svg') }}" alt="Hyper Best"></div>
                </div>
                <div class="awards-logos-row row-bottom">
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-5.svg') }}" alt="International Mega Standard"></div>
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-6.svg') }}" alt="Ultra Prestigious"></div>
                    <div class="award-logo-item"><img src="{{ asset('img/logos/logo-ipsum-7.svg') }}" alt="Logoipsum 2"></div>
                </div>
            </div>
            <div class="awards-description-box">
                <p>Mi gravida faucibus orci facilisis at amet, enim, aliquet pulvinar tempor et pretium a adipiscing ut lacinia dignissim et morbi semper sed suspendisse erat risus ligula duis pretium laoreet turpis in pharetra, sit fermentum mauris ac maecenas viverra netus ornare bibendum tristique dignissim lorem tincidunt vitae amet neque.</p>
            </div>
            <hr class="awards-divider">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-header">
                        <svg class="stat-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="2" width="20" height="20" rx="5" fill="#E1306C"/>
                            <path d="M12 7a5 5 0 100 10 5 5 0 000-10zm0 8a3 3 0 110-6 3 3 0 010 6z" fill="white"/>
                            <circle cx="17.5" cy="6.5" r="1.5" fill="white"/>
                        </svg>
                        <span class="stat-number">1.8M+</span>
                    </div>
                    <span class="stat-label">FOLLOWERS</span>
                </div>
                <div class="stat-item">
                    <div class="stat-header">
                        <svg class="stat-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24" rx="5" fill="#35465C"/>
                            <path d="M14.2 18c-1.8 0-2.8-1-2.8-3v-5H10V8.2c1.4-.4 2-.8 2.3-2.2h1.5v2.2h2.7V10h-2.7v4.6c0 .7.3 1.1 1 1.1h1.7V18h-2.3z" fill="white"/>
                        </svg>
                        <span class="stat-number">800K+</span>
                    </div>
                    <span class="stat-label">READERS</span>
                </div>
                <div class="stat-item">
                    <div class="stat-header">
                        <svg class="stat-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="24" height="24" rx="5" fill="#1877F2"/>
                            <path d="M14 13.5h2.5l.5-3H14V8.7c0-.8.2-1.2 1.2-1.2H17V5c-.6-.1-1.6-.2-2.5-.2-2.5 0-4 1.3-4 4.2v2H8.5v3H10.5V20h3.5v-6.5z" fill="white"/>
                        </svg>
                        <span class="stat-number">1.2M+</span>
                    </div>
                    <span class="stat-label">LIKES</span>
                </div>
            </div>
        </div>
    </section>
@endsection
