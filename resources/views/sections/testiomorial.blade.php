@if($testimonial)
    <section class="testimonial-section">
        <div class="container testimonial-container">
            {{-- Иконка кавычек --}}
            <div class="testimonial-quote-icon">
                <svg width="48" height="34" viewBox="0 0 48 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 19.3103C0 8.58621 8.27586 0 18.2069 0V7.03448C13.2414 7.03448 9.93103 10.7586 9.93103 15.1724H18.2069V33.1034H0V19.3103ZM29.7931 19.3103C29.7931 8.58621 38.069 0 48 0V7.03448C43.0345 7.03448 39.7241 10.7586 39.7241 15.1724H48V33.1034H29.7931V19.3103Z" fill="#2fdad7"/>
                </svg>
            </div>

            {{-- Динамический текст цитаты --}}
            <blockquote class="testimonial-text">
                {{ $testimonial->quote }}
            </blockquote>

            {{-- Блок автора с оригинальными классами --}}
            <div class="testimonial-author">
                <span class="author-name">{{ $testimonial->author_name }}</span>
                <span class="author-role">{{ $testimonial->author_title }}</span>
            </div>
        </div>
    </section>
@endif
