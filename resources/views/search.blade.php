@extends('layouts.app')

@section('content')
    <div class="search-page-wrapper" style="padding: 60px 0; min-height: 50vh;">
        <div class="container">

            <h1 class="search-title" style="font-size: 28px; margin-bottom: 20px; text-transform: uppercase;">
                {{ $settings->title }}
            </h1>

            @if($query)
                <p class="search-query-text" style="color: #666; margin-bottom: 40px;">
                    Вы искали: <strong style="color: #000;">"{{ $query }}"</strong>
                </p>
            @endif

            <div class="search-results-container">
                @if($results->isEmpty())
                    <div class="no-results" style="text-align: center; padding: 40px 0;">
                        <h3 style="font-size: 20px; color: #333; margin-bottom: 10px;">
                            {{ $settings->no_results_title }}
                        </h3>
                        <p style="color: #777; max-width: 600px; margin: 0 auto; line-height: 1.6;">
                            {{ $settings->no_results_text }}
                        </p>
                    </div>
                @else
                    <div class="results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px;">
                        @foreach($results as $result)
                            {{-- Карточки результатов (добавим, когда настроим картины) --}}
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
