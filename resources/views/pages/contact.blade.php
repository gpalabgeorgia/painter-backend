@extends('layouts.app')
@section('content')
    <!-- СЕКЦИЯ КОНТАКТОВ (CONTACT PAGE SECTION) -->
    <section class="contact-page-section">
        <div class="contact-container">
            <!-- Заголовок страницы с вертикальной красной линией -->
            <div class="contact-page-header">
                <h1 class="contact-main-title">Contact</h1>
                <div class="contact-top-red-line"></div>
            </div>
            <!-- Двухколоночный блок контента -->
            <div class="contact-content-wrapper">
                <!-- ЛЕВАЯ КОЛОНКА -->
                <div class="contact-info-col">
                    <div class="info-block">
                        {{-- Динамический заголовок ("Get in touch") --}}
                        <h3 class="contact-sub-title-serif">{{ $contacts->get('contact_title')?->value ?? 'Get in touch' }}</h3>
                        {{-- Динамическое описание под ним --}}
                        <p class="contact-text-muted">
                            {{ $contacts->get('contact_description')?->value ?? 'Feel free to contact me if you have any questions, about framing, paintings, art on paper.' }}
                        </p>
                    </div>
                    <hr class="contact-divider">
                    <div class="info-block">
                        <h3 class="contact-sub-title-serif">Zaza Papidze</h3>
                        <ul class="contact-details-list">
                            {{-- Физический адрес --}}
                            @if($contacts->has('address'))
                                <li>
                                    <!-- Точный маркер карты (сделали 18x24) -->
                                    <span class="contact-icon">
                                        <svg width="18" height="24" viewBox="0 0 24 24" fill="#d14332"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                                    </span>
                                    <span class="contact-detail-text">{{ $contacts->get('address')->value }}</span>
                                </li>
                            @endif

                            {{-- Телефон --}}
                            @if($contacts->has('phone'))
                                <li>
                                    <!-- Точная трубка телефона (сделали 18x18) -->
                                    <span class="contact-icon">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="#d14332"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                                    </span>
                                    <span class="contact-detail-text">
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contacts->get('phone')->value) }}" style="color: inherit; text-decoration: none;">
                                            {{ $contacts->get('phone')->value }}
                                        </a>
                                    </span>
                                </li>
                            @endif

                            {{-- Эл. почта --}}
                            @if($contacts->has('email'))
                                <li>
                                    <!-- Точный конверт почты (сделали 20x16) -->
                                    <span class="contact-icon">
                                        <svg width="20" height="16" viewBox="0 0 24 24" fill="none" stroke="#d14332" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    </span>
                                    <span class="contact-detail-text">
                                        <a href="mailto:{{ $contacts->get('email')->value }}" style="color: inherit; text-decoration: none;">
                                            {{ $contacts->get('email')->value }}
                                        </a>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <hr class="contact-divider">
                    <div class="info-block no-margin-bottom">
                        <span class="contact-follow-label">FOLLOW ME</span>
                        <div class="contact-social-grid">
                            <!-- Instagram (Круг в квадрате с точкой) -->
                            <div class="social-stat-item">
                                <div class="social-meta">
                                <span class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d14332" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                </span>
                                    <span class="social-number">1.8M+</span>
                                </div>
                                <span class="social-label">FOLLOWERS</span>
                            </div>
                            <!-- Tumblr (Буква 't' в скругленном квадрате) -->
                            <div class="social-stat-item">
                                <div class="social-meta">
                                <span class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" rx="4" fill="#d14332"/><path d="M14.2 16.5c-.8 0-1.2-.4-1.2-1.3v-5.4h2.2V8h-2.2V5.4H11V8H9.5v1.8H11v5.7c0 2 1.1 3.1 3 3.1.8 0 1.5-.2 1.9-.4V16c-.3.3-.8.5-1.4.5z" fill="#ffffff"/></svg>
                                </span>
                                    <span class="social-number">800K+</span>
                                </div>
                                <span class="social-label">READERS</span>
                            </div>
                            <!-- Facebook (Буква 'f' в скругленном квадрате) -->
                            <div class="social-stat-item">
                                <div class="social-meta">
                                <span class="social-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" rx="4" fill="#d14332"/><path d="M15 9h-2V7.5c0-.6.4-1 1-1h1V4h-2c-1.7 0-3 1.3-3 3v2H8v2.5h2V19h3v-7.5h2L15 9z" fill="#ffffff"/></svg>
                                </span>
                                    <span class="social-number">1.2M+</span>
                                </div>
                                <span class="social-label">LIKES</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ПРАВАЯ КОЛОНКА -->
                <div class="contact-form-col">
                    <h3 class="contact-sub-title-serif">Let's talk!</h3>

                    {{-- Вывод сообщения об успешной отправке --}}
                    @if(session('success'))
                        <div class="alert alert-success" style="color: #2e7d32; background: #e8f5e9; padding: 15px; margin-bottom: 20px; font-weight: bold;">
                            {{ session('success') }}
                        </div>
                    @endif


                    <form class="contact-html-form" action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Name <span class="required-star">*</span></label>
                            <input type="text" name="name" class="form-input" value="{{ old('name') }}" required>
                            @error('name') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email <span class="required-star">*</span></label>
                            <input type="email" name="email" class="form-input" value="{{ old('email') }}" required>
                            @error('email') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-input" value="{{ old('subject') }}">
                            @error('subject') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea class="form-textarea" name="message" rows="6">{{ old('message') }}</textarea>
                            @error('message') <span style="color: red; font-size: 12px;">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="form-submit-btn">SUBMIT</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
