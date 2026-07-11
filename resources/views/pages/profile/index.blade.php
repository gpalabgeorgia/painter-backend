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

        <form action="{{ route('account.update_info') }}" method="POST" enctype="multipart/form-data" style="background: #fff; border: 1px solid #eee; padding: 30px; border-radius: 8px; margin-bottom: 30px;">
            @csrf

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

            <h3 style="margin-top: 0; margin-bottom: 20px; font-size: 18px; color: #333;">Основная информация</h3>

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

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;" required>
                </div>
                <div>
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Номер телефона</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
                </div>
            </div>

            <button type="submit" style="background: #000; color: #fff; border: none; padding: 12px 25px; border-radius: 4px; cursor: pointer; font-weight: bold;">
                Сохранить личные данные
            </button>
        </form>


        <div style="background: #fff; border: 1px solid #eee; padding: 30px; border-radius: 8px; margin-bottom: 40px;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid #f5f5f5; padding-bottom: 15px;">
                <h3 style="margin: 0; font-size: 18px; color: #333;">Адреса доставки</h3>
                <button type="button" id="openAddAddressModal" style="background: #000; color: #fff; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 5px; transition: background 0.2s;" onmouseover="this.style.background='#222'" onmouseout="this.style.background='#000'">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Добавить адрес
                </button>
            </div>

            <div style="display: flex; flex-direction: column; gap: 15px;">

                @if(!empty($customer->address))
                    <div style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; display: flex; justify-content: space-between; align-items: flex-start; background: #fafafa;">
                        <div style="font-size: 14px; color: #333; line-height: 1.6; max-width: 80%;">
                            <div style="font-weight: 600; font-size: 15px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                <span>{{ $customer->name }} {{ $customer->last_name }}</span>
                                <span style="background: #333; color: #fff; padding: 2px 6px; border-radius: 4px; font-size: 10px; font-weight: 500; text-transform: uppercase;">Основной</span>
                                <span style="background: #e0e0e0; color: #333; padding: 2px 6px; border-radius: 4px; font-size: 11px; text-transform: uppercase;">{{ $customer->country }}</span>
                            </div>
                            <div><span style="color: #666;">Адрес:</span> {{ $customer->address }}</div>
                            <div><span style="color: #666;">Город/Регион:</span> {{ $customer->city }}{{ $customer->region ? ', ' . $customer->region : '' }}</div>
                            <div><span style="color: #666;">Индекс:</span> <span style="font-family: monospace;">{{ $customer->zip_code }}</span></div>
                            <div><span style="color: #666;">Email:</span> {{ $customer->email }}</div>
                            <div><span style="color: #666;">Телефон:</span> {{ $customer->phone ?? '—' }}</div>
                        </div>

                        <div style="display: flex; gap: 12px; align-items: center;">
                            <button type="button" class="edit-main-profile-address-btn" title="Редактировать основной профиль" style="background: none; border: none; color: #0056b3; cursor: pointer; padding: 5px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <button type="button" class="delete-address-btn" data-is-main="true" title="Удалить" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 5px;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if($customer->addresses && $customer->addresses->count() > 0)
                    @foreach($customer->addresses as $newAddress)
                        <div style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 20px; display: flex; justify-content: space-between; align-items: flex-start; background: #fff;">
                            <div style="font-size: 14px; color: #333; line-height: 1.6; max-width: 80%;">
                                <div style="font-weight: 600; font-size: 15px; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                                    <span>{{ $newAddress->first_name }} {{ $newAddress->last_name }}</span>
                                    <span style="background: #e0e0e0; color: #333; padding: 2px 6px; border-radius: 4px; font-size: 11px; text-transform: uppercase;">{{ $newAddress->country }}</span>
                                </div>
                                <div><span style="color: #666;">Адрес:</span> {{ $newAddress->address }}</div>
                                <div><span style="color: #666;">Город/Регион:</span> {{ $newAddress->city }}{{ $newAddress->region ? ', ' . $newAddress->region : '' }}</div>
                                <div><span style="color: #666;">Индекс:</span> <span style="font-family: monospace;">{{ $newAddress->zip_code }}</span></div>
                                <div><span style="color: #666;">Email:</span> {{ $newAddress->email }}</div>
                                <div><span style="color: #666;">Телефон:</span> {{ $newAddress->phone ?? '—' }}</div>
                            </div>

                            <div style="display: flex; gap: 12px; align-items: center;">
                                <button type="button" class="edit-additional-address-btn" data-id="{{ $newAddress->id }}" title="Редактировать" style="background: none; border: none; color: #0056b3; cursor: pointer; padding: 5px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button type="button" class="delete-address-btn" data-id="{{ $newAddress->id }}" data-is-main="false" title="Удалить" style="background: none; border: none; color: #dc3545; cursor: pointer; padding: 5px;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>

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

    <div id="addressWarningModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); justify-content: center; align-items: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;">
        <div id="addressWarningBox" style="background: #fff; padding: 30px; border-radius: 8px; max-width: 420px; width: 100%; text-align: center; box-shadow: 0 10px 25px rgba(0,0,0,0.1); transform: translateY(-20px); transition: transform 0.3s ease;">
            <div style="width: 56px; height: 56px; background: #fff5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h4 style="margin: 0 0 10px 0; font-size: 18px; color: #333; font-weight: 600;">Удаление невозможно</h4>
            <p style="margin: 0 0 20px 0; font-size: 14px; color: #666; line-height: 1.5;">
                Нельзя удалять единственный адрес. Вы можете изменить текущий адрес или добавить новый, а затем удалить этот.
            </p>
            <button type="button" id="closeAddressWarningBtn" style="background: #000; color: #fff; border: none; padding: 10px 25px; border-radius: 4px; cursor: pointer; font-weight: bold; width: 100%;">
                Понятно
            </button>
        </div>
    </div>

    <div id="confirmDeleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); justify-content: center; align-items: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;">
        <div id="confirmDeleteBox" style="background: #fff; padding: 30px; border-radius: 8px; max-width: 420px; width: 100%; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: translateY(-20px); transition: transform 0.3s ease;">
            <div style="width: 56px; height: 56px; background: #fff9db; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#f59f00" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
            <h3 style="margin: 0 0 10px 0; font-size: 18px; color: #333; font-weight: 600;">Удалить адрес доставки?</h3>
            <p style="margin: 0 0 25px 0; font-size: 14px; color: #666; line-height: 1.4;">Вы уверены, что хотите удалить этот адрес? Его нельзя будет восстановить в списке.</p>
            <div style="display: flex; justify-content: center; gap: 12px;">
                <button type="button" id="cancelDeleteBtn" style="background: #fff; color: #333; border: 1px solid #ccc; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px;">Отмена</button>
                <button type="button" id="submitDeleteBtn" style="background: #dc3545; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px;">Да, удалить</button>
            </div>
        </div>
    </div>

    <div id="addAddressModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); justify-content: center; align-items: center; z-index: 9999; opacity: 0; transition: opacity 0.3s ease;">
        <div id="addAddressBox" style="background: #fff; padding: 30px; border-radius: 8px; max-width: 600px; width: 100%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 30px rgba(0,0,0,0.15); transform: translateY(-20px); transition: transform 0.3s ease; font-family: inherit;">

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
                <h3 style="margin: 0; font-size: 20px; color: #333; font-weight: 600;">Добавить новый адрес</h3>
                <button type="button" id="closeAddAddressModal" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #999; line-height: 1; padding: 0;">&times;</button>
            </div>

            <form action="{{ route('account.addresses.store') }}" method="POST">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Имя *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $customer->name) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Фамилия *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $customer->last_name) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Эл. почта *</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Номер телефона</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Страна *</label>
                        <input type="text" name="country" value="{{ old('country') }}" placeholder="Например, Spain" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Регион / Область</label>
                        <input type="text" name="region" value="{{ old('region') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 15px; margin-bottom: 15px;">
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Город *</label>
                        <input type="text" name="city" value="{{ old('city') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                    <div>
                        <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Индекс *</label>
                        <input type="text" name="zip_code" value="{{ old('zip_code') }}" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;" required>
                    </div>
                </div>

                <div style="margin-bottom: 25px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500; font-size: 13px; color: #555;">Адрес (Улица, дом, квартира) *</label>
                    <textarea name="address" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; box-sizing: border-box;" required>{{ old('address') }}</textarea>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; border-top: 1px solid #eee; padding-top: 15px;">
                    <button type="button" id="cancelAddAddress" style="background: #fff; color: #333; border: 1px solid #ccc; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px;">Отмена</button>
                    <button type="submit" style="background: #000; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; font-weight: 600; font-size: 14px;">Сохранить адрес</button>
                </div>
            </form>
        </div>
    </div>

@endsection
