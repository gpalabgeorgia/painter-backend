@extends('layouts.app')

@section('content')
    <div class="profile-container" style="max-width: 800px; margin: 40px auto; padding: 0 20px; font-family: inherit;">

        <h2 style="margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px;">Мой аккаунт</h2>

        @if(session('success'))
            <div style="background: #2ecc71; color: #fff; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background: #e74c3c; color: #fff; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ФОРМА 1: ЛИЧНЫЕ ДАННЫЕ, АВАТАР И АДРЕС -->
        <form action="{{ route('account.update_info') }}" method="POST" enctype="multipart/form-data" style="background: #fff; border: 1px solid #eee; padding: 30px; border-radius: 8px; margin-bottom: 40px;">
            @csrf

            <!-- Аватар -->
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px; border-bottom: 1px solid #f5f5f5; padding-bottom: 20px;">
                <div class="avatar-preview">
                    @if($customer->avatar)
                        <img src="{{ Storage::url($customer->avatar) }}" alt="Avatar" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 1px solid #ccc;">
                    @else
                        <div style="width: 80px; height: 80px; border-radius: 50%; background: #333; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: bold; text-transform: uppercase;">
                            {{ mb_substr($customer->name, 0, 1) }}{{ mb_substr($customer->last_name, 0, 1) }}
                        </div>
                    @endif
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Фото профиля</label>
                    <input type="file" name="avatar" accept="image/*">
                </div>
            </div>

            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; color: #333;">Основная информация и адрес</h3>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Имя</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Фамилия</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Номер телефона</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <!-- Поля адреса -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Страна</label>
                    <input type="text" name="country" value="{{ old('country', $customer->country) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Регион / Область</label>
                    <input type="text" name="region" value="{{ old('region', $customer->region) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Город</label>
                    <input type="text" name="city" value="{{ old('city', $customer->city) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Почтовый индекс</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $customer->zip_code) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Адрес (Улица, дом, квартира)</label>
                <textarea name="address" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit;">{{ old('address', $customer->address) }}</textarea>
            </div>

            <button type="submit" style="background: #000; color: #fff; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                Сохранить данные
            </button>
        </form>

        <!-- ФОРМА 2: СМЕНА ПАРОЛЯ -->
        <form action="{{ route('account.update_password') }}" method="POST" style="background: #fff; border: 1px solid #eee; padding: 30px; border-radius: 8px;">
            @csrf
            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; color: #333; border-bottom: 1px solid #f5f5f5; padding-bottom: 10px;">Безопасность</h3>

            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: 500;">Текущий пароль</label>
                <input type="password" name="current_password" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Новый пароль</label>
                    <input type="password" name="new_password" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Повторение нового пароля</label>
                    <input type="password" name="new_password_confirmation" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
            </div>

            <button type="submit" style="background: #000; color: #fff; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                Изменить пароль
            </button>
        </form>

    </div>
@endsection
