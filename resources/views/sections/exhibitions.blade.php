@if($exhibitions->count() > 0)
    <section class="exhibitions-section">
        <div class="container exhibitions-container">

            <div class="exhibitions-header">
                {{-- Выводим динамический заголовок с фолбэком --}}
                <h2 class="exhibitions-main-title">{{ $exhibitionHeader->main_title ?? 'Upcoming exhibitions' }}</h2>

                @if(!empty($exhibitionHeader->subtitle))
                    <p class="exhibitions-subtitle">{{ $exhibitionHeader->subtitle }}</p>
                @endif
            </div>

            <div class="exhibitions-grid">
                @foreach($exhibitions as $exhibition)
                    <div class="exhibit-card">
                        <div class="card-image">
                            <img src="{{ asset(str_replace('public/', '', $exhibition->image)) }}" alt="{{ $exhibition->title }}">
                        </div>
                        <div class="card-content">
                            <span class="card-date">{{ $exhibition->date_range }}</span>
                            <h3 class="card-title">{{ $exhibition->title }}</h3>
                            <p class="card-text">{{ $exhibition->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif
