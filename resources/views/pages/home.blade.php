@extends('layouts.app')
@section('content')
    @include('sections.hero')

    @include('sections.energy')

    @include('sections.video')

    @include('sections.exhibitions')

    @include('sections.testiomorial')

    @include('sections.promo')

    @include('sections.artworks')

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
