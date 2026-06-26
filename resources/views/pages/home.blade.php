@extends('layouts.app')
@section('content')
    @include('sections.hero')

    @include('sections.energy')

    @include('sections.video')

    @include('sections.exhibitions')

    @include('sections.testiomorial')

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
