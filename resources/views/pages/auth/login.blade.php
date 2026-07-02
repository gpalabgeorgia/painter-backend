@extends('layouts.app')
@section('content')
    <div class="auth-container">
        <div class="auth-card">
            <h2 class="auth-title">Sign In</h2>
            <p class="auth-subtitle">Welcome back! Please enter your details.</p>

            <!-- Вывод общих ошибок валидации -->
            @if ($errors->any())
                <div style="color: #e74c3c; margin-bottom: 20px; font-size: 14px; text-align: left;">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>
                </div>

                <button type="submit" class="auth-submit-btn">SIGN IN</button>
            </form>

            <div class="auth-footer">
                <p>Вы не зарегистрированы? <a href="{{ url('/register') }}">Создать аккаунт</a></p>
            </div>
        </div>
    </div>
@endsection
