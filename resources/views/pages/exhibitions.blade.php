@extends('layouts.app')
@section('content')
    <!-- ==========================================================================
   СЕКЦИЯ ВЫСТАВОК (EXHIBITIONS)
   ========================================================================== */ -->
    @if($currentExhibition)
        <section class="exhibitions-banner-section">

            <div class="exhibitions-top-header">
                <h2 class="exhibitions-title-text">{{ $currentExhibition->page_title ?? 'Exhibitions' }}</h2>
                <div class="exhibitions-red-line"></div>
            </div>

            <div class="exhibition-dark-inner-banner" style="background-image: url('{{ asset('storage/' . $currentExhibition->bg_image) }}');">
                <div class="exhibition-banner-content">

                    <div class="exh-left-meta">
                        <span class="exh-badge">{{ $currentExhibition->subtitle ?? 'CURRENT EXHIBITION' }}</span>
                        <h3 class="exh-main-title">{!! nl2br(e($currentExhibition->title)) !!}</h3>
                        <span class="exh-date-range">
                    {{ \Carbon\Carbon::parse($currentExhibition->start_date)->format('M d') }} -
                    {{ \Carbon\Carbon::parse($currentExhibition->end_date)->format('M d') }}
                </span>
                    </div>

                    <div class="exh-right-details">
                        <p class="exh-description">
                            {{ $currentExhibition->description }}
                        </p>
                        <a href="#" class="exh-read-more">READ MORE &rarr;</a>
                    </div>

                </div>
            </div>

        </section>
    @endif

    @if($upcomingExhibitions->isNotEmpty())
        <section class="upcoming-exhibitions-section" style="background-image: url('{{ asset('img/exhibitions-gradient-line-bg.svg') }}');">
            <div class="upcoming-container">
                <div class="upcoming-header">
                    {{-- Глобальные заголовок и подзаголовок секции --}}
                    <h2 class="upcoming-section-title">
                        {{ $upcomingExhibitions->first()->title ?? 'Upcoming Exhibitions' }}
                    </h2>
                    <p class="upcoming-section-subtitle">
                        {!! nl2br(e($upcomingExhibitions->first()->description ?? 'Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.')) !!}
                    </p>
                </div>
                <div class="upcoming-grid">
                    @foreach($upcomingExhibitions as $upcoming)
                        <div class="upcoming-card">
                            <div class="card-img-wrapper">
                                {{-- Отрезаем 'public/' от пути из базы, чтобы картинка стопроцентно открылась --}}
                                <img src="{{ asset(\Illuminate\Support\Str::after($upcoming->image, 'public/')) }}" alt="{{ $upcoming->title }}" class="card-img">
                            </div>
                            <div class="card-content">
                                {{-- ВЫВОДИМ ИСПРАВЛЕННУЮ ДАТУ НАПРЯМУЮ ИЗ ТВОЕЙ КОЛОНКИ --}}
                                <span class="card-date">
                            {{ $upcoming->date_range }}
                        </span>
                                <h4 class="card-title">{{ $upcoming->title }}</h4>

                                <p class="card-desc">
                                    {{ $upcoming->description }}
                                </p>

                                <a href="{{ $upcoming->link ?? '#' }}" class="card-link">READ MORE &rarr;</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- СЕКЦИЯ ПРОШЕДШИХ ВЫСТАВОК (PAST EXHIBITIONS) -->
    <section class="past-exhibitions-section">
        <div class="past-container">

            <div class="past-header">
                <h2 class="past-section-title">
                    {!! nl2br(e($pastHeader->section_title ?? 'Past Exhibitions')) !!}
                </h2>

                <div class="past-header-right">
                    <div class="past-red-line"></div>
                    <p class="past-section-subtitle">
                        {{ $pastHeader->section_description ?? 'Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.' }}
                    </p>
                </div>
            </div>

            <div class="past-grid">
                @foreach($pastExhibitions as $past)
                    <div class="past-card">
                        <div class="past-img-box">
                            <img src="{{ asset($past->image) }}" alt="{{ $past->title }}" class="past-img">
                        </div>
                        <h4 class="past-card-title">{{ $past->title }}</h4>
                        <p class="past-card-desc">{{ $past->description }}</p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    @include('sections.subscribe')
@endsection
