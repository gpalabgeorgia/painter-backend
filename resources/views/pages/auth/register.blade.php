@extends('layouts.app')
@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <h2 class="auth-title">Register</h2>
            <p class="auth-subtitle">Create your account to start collecting art.</p>

            <!-- Вывод ошибок валидации -->
            @if ($errors->any())
                <div style="color: #e74c3c; margin-bottom: 20px; font-size: 14px; text-align: left;">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="name">First Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="John" required>
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="enter your email" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone (optional)</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="+123456789">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                </div>

                <button type="submit" class="auth-submit-btn">CREATE ACCOUNT</button>
            </form>

            <div class="auth-footer">
                <p>Уже есть аккаунт? <a href="{{ url('/login') }}">Войти</a></p>
            </div>
        </div>
    </div>
@endsection
