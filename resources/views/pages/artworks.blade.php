@extends('layouts.app')
@section('content')
    <!-- СЕКЦИЯ ARTWORKS -->
    <section class="artworks-section">
        <div class="artworks-container">
            @if($artworksData)
                <h2 class="artworks-title">{{ $artworksData->s1_title }}</h2>

                <div class="artwork-card">
                    <div class="artwork-frame">
                        <img src="{{ asset('storage/' . $artworksData->s1_image) }}" alt="{{ $artworksData->s1_subtitle }}" class="artwork-image">
                    </div>
                    <h3 class="artwork-name">{{ $artworksData->s1_subtitle }}</h3>
                    <p class="artwork-desc">{{ $artworksData->s1_text }}</p>
                    <a href="#" class="artwork-link">LEARN MORE &rarr;</a>
                </div>
            @endif
            <div class="artworks-footer-line"></div>
        </div>
    </section>
    <!-- СЕКЦИЯ ГАЛЕРЕИ РАБОТ -->
    <section class="artworks-gallery-section" id="gallery">
        <div class="gallery-container">

            <div class="artworks-grid">
                @foreach($artworkItems as $item)
                    <div class="gallery-item {{ $loop->iteration % 2 == 0 ? 'item-white-frame' : 'item-dark-frame' }}">
                        <div class="gallery-frame">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="gallery-image">
                        </div>
                        <h3 class="gallery-item-name">{{ $item->title }}</h3>
                        <p class="gallery-item-desc">{{ $item->description }}</p>
                        <a href="#" class="gallery-item-link">LEARN MORE &rarr;</a>
                    </div>
                @endforeach
            </div>

            {{-- Блок пагинации с жестким якорем на эту секцию --}}
            @if($artworkItems->hasPages())
                <div class="custom-artworks-pagination" style="margin-top: 50px; display: flex; justify-content: center;">
                    {{-- Метод ->fragment('gallery') делает всю магию фокуса! --}}
                    {{ $artworkItems->fragment('gallery')->links() }}
                </div>
            @endif

        </div>
    </section>

    @include('sections.subscribe')
@endsection
