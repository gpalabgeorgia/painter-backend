<div class="p-6 bg-white border border-gray-300 shadow-sm rounded-xl dark:bg-gray-800 dark:border-gray-700 mb-6">
    {{-- Шапка блока: заголовок слева, кнопка добавления справа --}}
    <div class="flex items-center justify-between mb-4 flex-wrap gap-4">
        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white">
            📌 Настройки шапки секции выставок
        </h3>

        {{-- Кнопка создания новой выставки --}}
        <a href="{{ route('filament.resources.exhibitions.create') }}"
           class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white transition-colors rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-offset-2 bg-primary-600 hover:bg-primary-500 focus:ring-primary-600"
           style="background-color: #d97706;">
            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Добавить выставку
        </a>
    </div>

    <form action="{{ route('filament.exhibitions.save-headers') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Главный заголовок секции</label>
                <input type="text" name="main_title" value="{{ $main_title }}" required
                       class="block w-full transition duration-700 ease-in-out border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Подзаголовок (описание)</label>
                <input type="text" name="subtitle" value="{{ $subtitle }}"
                       class="block w-full transition duration-700 ease-in-out border-gray-300 rounded-lg shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white text-sm">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-offset-2 bg-primary-600 hover:bg-primary-500 focus:ring-primary-600 font-semibold" style="background-color: #d97706;">
                Сохранить заголовки секции
            </button>
        </div>
    </form>
</div>
