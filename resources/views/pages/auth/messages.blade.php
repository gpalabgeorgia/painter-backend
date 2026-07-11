@extends('layouts.app')

@section('content')
    <style>
        @keyframes fadeInModal {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

    <div class="container" style="padding: 40px 0; max-width: 800px; margin: 0 auto; font-family: inherit;">
        <h2 style="font-size: 24px; font-weight: 600; margin-bottom: 25px; color: #111827;">Мои сообщения</h2>

        {{-- Уведомления об успешном действии (Удалено / Отправлено) --}}
        @if(session('success'))
            <div style="padding: 12px 16px; background: #bbf7d0; color: #166534; border-radius: 6px; margin-bottom: 20px; font-size: 14px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif

        @if($messages->isEmpty())
            <div style="text-align: center; padding: 40px; background: #f9fafb; border: 1px dashed #d1d5db; border-radius: 8px; color: #6b7280;">
                У вас пока нет сообщений.
            </div>
        @else
            <div style="display: flex; flex-direction: column; gap: 20px;">
                @foreach($messages as $msg)
                    @php
                        // Цветовые схемы под разные типы системных сообщений
                        $colors = [
                            'success' => ['bg' => '#f0fdf4', 'border' => '#bbf7d0', 'text' => '#166534'],
                            'danger'  => ['bg' => '#fef2f2', 'border' => '#fecaca', 'text' => '#991b1b'],
                            'warning' => ['bg' => '#fffbeb', 'border' => '#fef3c7', 'text' => '#92400e'],
                            'info'    => ['bg' => '#f0f9ff', 'border' => '#bae6fd', 'text' => '#075985'],
                        ];
                        $currentStyle = $colors[$msg->type] ?? $colors['info'];
                    @endphp

                    <div style="background: {{ $currentStyle['bg'] }}; border: 1px solid {{ $currentStyle['border'] }}; border-radius: 8px; padding: 20px;">

                        {{-- Шапка сообщения --}}
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                            <h4 style="margin: 0; font-size: 16px; font-weight: 600; color: {{ $currentStyle['text'] }};">
                                {{ $msg->title }}
                            </h4>
                            <span style="font-size: 12px; color: #6b7280;">
                                {{ $msg->created_at->format('d.m.Y H:i') }}
                            </span>
                        </div>

                        {{-- Текст сообщения --}}
                        <p style="margin: 0 0 15px 0; font-size: 14px; color: #374151; line-height: 1.5;">
                            {{ $msg->message }}
                        </p>

                        {{-- Панель управления (Кнопки Ответить и Удалить) --}}
                        <div style="display: flex; gap: 20px; border-top: 1px solid {{ $currentStyle['border'] }}; padding-top: 12px;">

                            {{-- Кнопка Ответить (Раскрывает текстовое поле без перезагрузки) --}}
                            <button type="button" onclick="toggleReplyForm({{ $msg->id }})" style="background: none; border: none; color: #2563eb; font-size: 13px; font-weight: 600; cursor: pointer; padding: 0; font-family: inherit;">
                                Ответить
                            </button>

                            {{-- Кнопка Удалить (Открывает кастомную модалку) --}}
                            <button type="button" onclick="showDeleteModal({{ $msg->id }})" style="background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 600; cursor: pointer; padding: 0; font-family: inherit;">
                                Удалить
                            </button>
                        </div>

                        {{-- Красивая кастомная модалка подтверждения удаления --}}
                        <div id="delete-modal-{{ $msg->id }}" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(4px); z-index: 9999; align-items: center; justify-content: center;">
                            <div style="background: #fff; padding: 24px; border-radius: 12px; max-width: 400px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); text-align: center; animation: fadeInModal 0.2s ease-out;">
                                <div style="width: 48px; height: 48px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                    <svg style="width: 24px; height: 24px; color: #dc2626;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <h3 style="margin: 0 0 8px 0; font-size: 18px; font-weight: 600; color: #111827;">Удалить сообщение?</h3>
                                <p style="margin: 0 0 24px 0; font-size: 14px; color: #6b7280; line-height: 1.5;">Вы уверены, что хотите удалить это сообщение? Это действие нельзя будет отменить.</p>

                                <div style="display: flex; gap: 12px; justify-content: center;">
                                    <button type="button" onclick="hideDeleteModal({{ $msg->id }})" style="flex: 1; background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; font-family: inherit;">
                                        Отмена
                                    </button>
                                    <form action="{{ route('profile.notifications.destroy', $msg->id) }}" method="POST" style="margin: 0; flex: 1;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="width: 100%; background: #dc2626; color: #fff; border: none; padding: 10px 16px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 500; font-family: inherit;">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Скрытая форма для ввода текста ответа --}}
                        <div id="reply-form-{{ $msg->id }}" style="display: none; margin-top: 15px; background: #fff; padding: 15px; border: 1px solid #e5e7eb; border-radius: 6px;">
                            <form action="{{ route('profile.notifications.reply', $msg->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                <textarea name="message" rows="3" placeholder="Введите ваш текст ответа администратору..." required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; font-family: inherit; font-size: 14px; outline: none; resize: vertical; box-sizing: border-box; margin-bottom: 10px;"></textarea>

                                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                                    <button type="button" onclick="toggleReplyForm({{ $msg->id }})" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; font-family: inherit;">
                                        Отмена
                                    </button>
                                    <button type="submit" style="background: #2563eb; color: #fff; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 13px; font-weight: 500; font-family: inherit;">
                                        Отправить ответ
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        // Показать/скрыть поле ответа
        function toggleReplyForm(id) {
            const form = document.getElementById('reply-form-' + id);
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }

        // Управление кастомной модалкой удаления
        function showDeleteModal(id) {
            document.getElementById('delete-modal-' + id).style.display = 'flex';
        }

        function hideDeleteModal(id) {
            document.getElementById('delete-modal-' + id).style.display = 'none';
        }
    </script>
@endsection
