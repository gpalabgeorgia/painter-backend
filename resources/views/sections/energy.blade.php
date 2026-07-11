@if($energy && $energy->is_active)
    <section id="next-section" class="energy-section">
        <div class="container energy-container">
            <div class="section-divider"></div>
            <div class="energy-content">
                {{-- Динамический главный большой заголовок --}}
                <h2 class="energy-title">
                    {{ $energy->title }}
                </h2>

                <div class="energy-text-wrap">
                    {{-- Первый абзац --}}
                    @if($energy->text_1)
                        <p>{{ $energy->text_1 }}</p>
                    @endif

                    {{-- Второй абзац --}}
                    @if($energy->text_2)
                        <p>{{ $energy->text_2 }}</p>
                    @endif
                    <a href="{{ url('/about') }}" class="read-more-btn">READ MORE &rarr;</a>
                </div>
            </div>

            {{-- Блок статистики (структура и классы иконок сохранены на 100%, значения пока статика) --}}
            <div class="energy-stats">
                <div class="stat-item">
                    <div class="stat-icon instagram"><i class="fab fa-instagram"></i></div>
                    <div class="stat-info">
                        <h3>1.8M+</h3>
                        <p>FOLLOWERS</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon tumblr"><i class="fab fa-tumblr-square"></i></div>
                    <div class="stat-info">
                        <h3>800K+</h3>
                        <p>READERS</p>
                    </div>
                </div>

                <div class="stat-item">
                    <div class="stat-icon facebook"><i class="fab fa-facebook-square"></i></div>
                    <div class="stat-info">
                        <h3>1.2M+</h3>
                        <p>LIKES</p>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endif
