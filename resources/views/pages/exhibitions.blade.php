@extends('layouts.app')
@section('content')
    <!-- ==========================================================================
   СЕКЦИЯ ВЫСТАВОК (EXHIBITIONS)
   ========================================================================== */ -->
    @include('sections.exhibitions')
{{--    <section class="exhibitions-banner-section">--}}

{{--        <div class="exhibitions-top-header">--}}
{{--            <h2 class="exhibitions-title-text">Exhibitions</h2>--}}
{{--            <div class="exhibitions-red-line"></div>--}}
{{--        </div>--}}

{{--        <div class="exhibition-dark-inner-banner" style="background-image: url('img/exhibition-bg-img.jpg');">--}}
{{--            <div class="exhibition-banner-content">--}}

{{--                <div class="exh-left-meta">--}}
{{--                    <span class="exh-badge">CURRENT EXHIBITION</span>--}}
{{--                    <h3 class="exh-main-title">All Belong to<br>Nature</h3>--}}
{{--                    <span class="exh-date-range">Jun 14 - Jul 12</span>--}}
{{--                </div>--}}

{{--                <div class="exh-right-details">--}}
{{--                    <p class="exh-description">--}}
{{--                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.--}}
{{--                    </p>--}}
{{--                    <a href="#" class="exh-read-more">READ MORE &rarr;</a>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--    </section>--}}
    <section class="upcoming-exhibitions-section" style="background-image: url('img/exhibitions-gradient-line-bg.svg');">
        <div class="upcoming-container">
            <div class="upcoming-header">
                <h2 class="upcoming-section-title">Upcoming Exhibitions</h2>
                <p class="upcoming-section-subtitle">
                    Tempor ac tincidunt feugiat dignissim quis sed donec cursus<br>ornare varius sed sagittis nibh.
                </p>
            </div>
            <div class="upcoming-grid">
                <div class="upcoming-card">
                    <div class="card-img-wrapper">
                        <img src="img/exhibition-img-1.jpg" alt="Exhibition 1" class="card-img">
                    </div>
                    <div class="card-content">
                        <span class="card-date">Jun 12 - Jul 16</span>
                        <h4 class="card-title">Risus diam lacus</h4>
                        <p class="card-desc">
                            Semper convallis urna amet, tortor commodo vitae tempor leo, aliquet nibh ipsum sed posuere.
                        </p>
                        <a href="#" class="card-link">READ MORE &rarr;</a>
                    </div>
                </div>
                <div class="upcoming-card">
                    <div class="card-img-wrapper">
                        <img src="img/exhibition-img-2.jpg" alt="Exhibition 2" class="card-img">
                    </div>
                    <div class="card-content">
                        <span class="card-date">Jul 28 - Aug 20</span>
                        <h4 class="card-title">Tortor ut dignissim</h4>
                        <p class="card-desc">
                            Aliquam egestas facilisi nunc nibh amet cras eget sed mus nibh iaculis scelerisque morbi imperdiet.
                        </p>
                        <a href="#" class="card-link">READ MORE &rarr;</a>
                    </div>
                </div>
                <div class="upcoming-card">
                    <div class="card-img-wrapper">
                        <img src="img/exhibition-img-3.jpg" alt="Exhibition 3" class="card-img">
                    </div>
                    <div class="card-content">
                        <span class="card-date">Sep 16 - Oct 8</span>
                        <h4 class="card-title">Ultrices pulvinar</h4>
                        <p class="card-desc">
                            Turpis pharetra velit tortor vitae sit ipsum aliquam tortor sem et ac faucibus mattis ac.
                        </p>
                        <a href="#" class="card-link">READ MORE &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- СЕКЦИЯ ПРОШЕДШИХ ВЫСТАВОК (PAST EXHIBITIONS) -->
    <section class="past-exhibitions-section">
        <div class="past-container">
            <!-- Шапка секции (Заголовок слева, описание справа с красной линией) -->
            <div class="past-header">
                <h2 class="past-section-title">Past<br>Exhibitions</h2>
                <div class="past-header-right">
                    <div class="past-red-line"></div>
                    <p class="past-section-subtitle">
                        Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.
                    </p>
                </div>
            </div>
            <!-- Сетка карточек (Grid 4x2) -->
            <div class="past-grid">
                <!-- Карточка 1 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-1.jpg" alt="Convallis Arcu" class="past-img">
                    </div>
                    <h4 class="past-card-title">Convallis Arcu</h4>
                    <p class="past-card-desc">Congue integer imperdiet viverra integer quis sapien odio mauris elementum</p>
                </div>

                <!-- Карточка 2 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-2.jpg" alt="Sit Porta Vestibulum" class="past-img">
                    </div>
                    <h4 class="past-card-title">Sit Porta Vestibulum</h4>
                    <p class="past-card-desc">Nibh sed ornare eget eu hendrerit mauris euismod fermentum</p>
                </div>

                <!-- Карточка 3 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-3.jpg" alt="Sed Gravida" class="past-img">
                    </div>
                    <h4 class="past-card-title">Sed Gravida</h4>
                    <p class="past-card-desc">Quam odio eu morbi lobortis libero in sed pellentesque adipiscing</p>
                </div>

                <!-- Карточка 4 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-4.jpg" alt="Quis Egestas" class="past-img">
                    </div>
                    <h4 class="past-card-title">Quis Egestas</h4>
                    <p class="past-card-desc">Sagittis odio at tellus lobortis tempus dolor a at dignissim</p>
                </div>

                <!-- Карточка 5 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-5.jpg" alt="Volutpat Quis" class="past-img">
                    </div>
                    <h4 class="past-card-title">Volutpat Quis</h4>
                    <p class="past-card-desc">Aenean nulla integer est nulla leo interdum tortor vel lorem</p>
                </div>

                <!-- Карточка 6 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-6.jpg" alt="Urna Laoreet" class="past-img">
                    </div>
                    <h4 class="past-card-title">Urna Laoreet</h4>
                    <p class="past-card-desc">Nunc diam nunc donec ultrices rhoncus ut etiam a egestas</p>
                </div>

                <!-- Карточка 7 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-7.jpg" alt="Urna in Tincidunt" class="past-img">
                    </div>
                    <h4 class="past-card-title">Urna in Tincidunt</h4>
                    <p class="past-card-desc">Varius pharetra mauris tortor porttitor magna ipsum quam et non</p>
                </div>

                <!-- Карточка 8 -->
                <div class="past-card">
                    <div class="past-img-box">
                        <img src="img/exhibition-8.jpg" alt="Sed Nibh Elementum" class="past-img">
                    </div>
                    <h4 class="past-card-title">Sed Nibh Elementum</h4>
                    <p class="past-card-desc">Mauris orci augue odio odio amet interdum nulla et volutpat</p>
                </div>

            </div>

        </div>
    </section>
@endsection
