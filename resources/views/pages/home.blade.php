@extends('layouts.app')
@section('content')
    @include('sections.hero')

    @include('sections.energy')

    @include('sections.video')

    <section class="exhibitions-section">
        <div class="container exhibitions-container">
            <div class="exhibitions-header">
                <h2 class="exhibitions-main-title">Upcoming exhibitions</h2>
                <p class="exhibitions-subtitle">Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.</p>
            </div>
            <div class="exhibitions-grid">
                <div class="exhibit-card">
                    <div class="card-image">
                        <img src="img/painter-artist-portfolio-exhibition-img-1.jpg" alt="Risus diam lacus">
                    </div>
                    <div class="card-content">
                        <span class="card-date">Jun 12 - Jul 16</span>
                        <h3 class="card-title">Risus diam lacus</h3>
                        <p class="card-text">Semper convallis urna amet, tortor commodo vitae tempor leo, aliquet nibh ipsum sed posuere.</p>
                        <a href="#" class="card-link">READ MORE &rarr;</a>
                    </div>
                </div>
                <div class="exhibit-card">
                    <div class="card-image">
                        <img src="img/exhibition-img-2.jpg" alt="Tortor ut dignissim">
                    </div>
                    <div class="card-content">
                        <span class="card-date">Jul 28 - Aug 20</span>
                        <h3 class="card-title">Tortor ut dignissim</h3>
                        <p class="card-text">Aliquam egestas facilisi nunc nibh cras eget sed mus nibh iaculis scelerisque morbi imperdiet.</p>
                        <a href="#" class="card-link">READ MORE &rarr;</a>
                    </div>
                </div>
                <div class="exhibit-card">
                    <div class="card-image">
                        <img src="img/exhibition-img-3.jpg" alt="Ultrices pulvinar">
                    </div>
                    <div class="card-content">
                        <span class="card-date">Sep 16 - Oct 8</span>
                        <h3 class="card-title">Ultrices pulvinar</h3>
                        <p class="card-text">Turpis pharetra velit tortor vitae sit ipsum aliquam tortor sem et ac faucibus mattis ac.</p>
                        <a href="#" class="card-link">READ MORE &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="testimonial-section">
        <div class="container testimonial-container">
            <div class="testimonial-quote-icon">
                <svg width="48" height="34" viewBox="0 0 48 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 19.3103C0 8.58621 8.27586 0 18.2069 0V7.03448C13.2414 7.03448 9.93103 10.7586 9.93103 15.1724H18.2069V33.1034H0V19.3103ZM29.7931 19.3103C29.7931 8.58621 38.069 0 48 0V7.03448C43.0345 7.03448 39.7241 10.7586 39.7241 15.1724H48V33.1034H29.7931V19.3103Z" fill="#2fdad7"/>
                </svg>
            </div>
            <blockquote class="testimonial-text">
                Really beautiful professional abstracts led quis malesuada aenean risus, gravida eu nunc quis bibendum venenatis.
            </blockquote>
            <div class="testimonial-author">
                <span class="author-name">Jonathan Doe</span>
                <span class="author-role">ABC Architect</span>
            </div>
        </div>
    </section>
    <section class="learn-section">
        <div class="container">
            <div class="learn-card-box">

                <img src="img/gradient-line-bg-3.svg" alt="Background shape" class="learn-blob">

                <div class="learn-image-wrapper">
                    <img src="img/learn-painting-cta.png" alt="Painter with brush">
                </div>

                <div class="learn-text-content">
                    <h2 class="learn-title">Learn Painting</h2>
                    <p class="learn-descr">Diam praesent ullamcorper cursus integer ullamcorper ac lorem scelerisque faucibus dignissim eget sapien.</p>
                    <a href="#" class="learn-btn">START NOW</a>
                </div>

            </div>
        </div>
    </section>
    <section class="artwork-section">
        <div class="artwork-container">
            <div class="artwork-header">
                <div class="artwork-header-left">
                    <h2>Latest artwork</h2>
                    <p>Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.</p>
                </div>
                <div class="artwork-header-right">
                    <a href="#" class="view-all-btn">VIEW ALL <span>&rarr;</span></a>
                </div>
            </div>
            <div class="artwork-grid">
                <div class="artwork-card">
                    <div class="artwork-img-box">
                        <img src="img/product-img-8-300x400.jpg" alt="Starry Night">
                    </div>
                    <div class="artwork-info">
                        <span class="artwork-category">Sticks</span>
                        <h3 class="artwork-title">Starry Night</h3>
                        <span class="artwork-price">$640.00</span>
                        <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-img-box">
                        <img src="img/product-img-4-300x400.jpg" alt="Majesty">
                    </div>
                    <div class="artwork-info">
                        <span class="artwork-category">Sticks</span>
                        <h3 class="artwork-title">Majesty</h3>
                        <span class="artwork-price">$400.00</span>
                        <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-img-box">
                        <img src="img/product-img-7-300x400.jpg" alt="Analogue">
                    </div>
                    <div class="artwork-info">
                        <span class="artwork-category">Abstract</span>
                        <h3 class="artwork-title">Analogue</h3>
                        <span class="artwork-price">$800.00</span>
                        <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-img-box">
                        <img src="img/product-img-2-300x400.jpg" alt="Meena Harbor">
                    </div>
                    <div class="artwork-info">
                        <span class="artwork-category">Abstract</span>
                        <h3 class="artwork-title">Meena Harbor</h3>
                        <span class="artwork-price">$640.00</span>
                        <a href="#" class="add-to-cart-btn">ADD TO CART</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="subscribe-section">
        <img src="img/gradient-line-bg-2.svg" alt="" class="subscribe-blob">

        <div class="subscribe-container">
            <div class="subscribe-card">
                <div class="subscribe-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4a5568" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <h2 class="subscribe-title">Get great content in your inbox</h2>
                <p class="subscribe-text">Ut ornare sed pellentesque id arcu nunc, sagittis mollis nisl ullamcorper ac adipiscing sed nec quam faucibus amet</p>
                <form class="subscribe-form" onsubmit="event.preventDefault();">
                    <input type="email" placeholder="Your Email please" class="subscribe-input" required>
                    <button type="submit" class="subscribe-btn">SUBSCRIBE</button>
                </form>
            </div>
        </div>
    </section>
@endsection
