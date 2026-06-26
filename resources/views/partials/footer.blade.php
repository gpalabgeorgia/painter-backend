<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-content">

            {{-- Логотип футера из отдельной таблицы logos --}}
            <div class="footer-logo">
                @if($logos && !empty($logos->footer_logo))
                    <img src="{{ Storage::url($logos->footer_logo) }}" alt="Zaza Papidze Logo" style="max-height: 50px;">
                @else
                    <h2>Zaza Papidze</h2>
                @endif
            </div>

            {{-- Навигация --}}
            <nav class="footer-nav">
                @if($footerMenus && $footerMenus->count() > 0)
                    @foreach($footerMenus as $item)
                        <a href="{{ $item->url ?? $item->link ?? '#' }}">{{ $item->label ?? $item->title }}</a>
                    @endforeach
                @endif
            </nav>

            {{-- Соцсети из таблицы контактов (Ничего не дублируем, иконки не пропадут) --}}
            <div class="footer-socials">
                <a href="{{ $contactData->instagram ?? '#' }}" target="_blank" aria-label="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>

                <a href="{{ $contactData->facebook ?? '#' }}" target="_blank" aria-label="Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                </a>

                <a href="{{ $contactData->twitter ?? '#' }}" target="_blank" aria-label="Twitter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <p class="copyright">Copyright &copy; {{ date('Y') }} GPALAB</p>
            <p class="powered">Powered by GPALAB</p>
        </div>
    </div>
</footer>
