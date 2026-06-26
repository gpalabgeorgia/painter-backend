@if($subscribeSection)
    <section class="subscribe-section">
        {{-- Оригинальный фоновый градиент --}}
        <img src="{{ asset('img/gradient-line-bg-2.svg') }}" alt="Background shape" class="subscribe-blob">

        <div class="subscribe-container">
            <div class="subscribe-card">

                {{-- Иконка письма --}}
                <div class="subscribe-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#4a5568" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>

                {{-- Динамические тексты из админки --}}
                <h2 class="subscribe-title">{{ $subscribeSection->title }}</h2>
                <p class="subscribe-text">{{ $subscribeSection->subtitle }}</p>

                {{-- Вывод уведомления об успешной подписке --}}
                @if(session('subscribe_success'))
                    <div style="color: #2e7d32; background-color: #e8f5e9; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
                        {{ session('subscribe_success') }}
                    </div>
                @endif

                {{-- Вывод ошибок валидации (например, если email уже есть в базе) --}}
                @error('email')
                <div style="color: #c62828; background-color: #ffebee; padding: 10px; border-radius: 4px; margin-bottom: 15px; text-align: center;">
                    {{ $message }}
                </div>
                @enderror

                {{-- Рабочая форма отправки на контроллер --}}
                <form action="{{ route('subscribe.store') }}" method="POST" class="subscribe-form">
                    @csrf
                    <input
                        type="email"
                        name="email"
                        placeholder="Your Email please"
                        class="subscribe-input"
                        value="{{ old('email') }}"
                        required
                    >
                    <button type="submit" class="subscribe-btn">SUBSCRIBE</button>
                </form>

            </div>
        </div>
    </section>
@endif
