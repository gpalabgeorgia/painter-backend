<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPageResource\Pages;
use App\Models\AboutPage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use App\Models\Language;

class AboutPageResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Страница О нас';

    // Фикс меню: Принудительно заставляем пункт меню вести сразу на редактирование записи с ID 1
    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit', ['record' => 1]);
    }

    public static function form(Form $form): Form
    {
        // 1. Получаем все дополнительные языки из базы, кроме основного (испанского 'es')
        // Если у тебя основной язык другой, замени 'es'
        $additionalLanguages = Language::where('code', '!=', 'es')->get();

        return $form
            ->schema([
                Forms\Components\Tabs::make('Sections')
                    ->tabs([
                        // ================== ПЕРВАЯ СЕКЦИЯ ==================
                        Forms\Components\Tabs\Tab::make('Первая секция')
                            ->schema([
                                Forms\Components\FileUpload::make('s1_image')
                                    ->label('Фото художника')
                                    ->disk('public')
                                    ->directory('about')
                                    ->image()
                                    ->required(),

                                Forms\Components\Tabs::make('s1_lang_tabs')
                                    ->tabs(array_merge([
                                        // Вкладка по умолчанию (Испанский)
                                        Forms\Components\Tabs\Tab::make('Español (Основной)')
                                            ->schema([
                                                Forms\Components\TextInput::make('s1_title')->label('Заголовок секции (ES)')->required(),
                                                Forms\Components\TextInput::make('s1_subtitle')->label('Заголовок текста (ES)')->required(),
                                                Forms\Components\RichEditor::make('s1_text')->label('Текст секции (ES)')->required(),
                                            ]),
                                    ],
                                        // Автоматически генерируем вкладки для всех остальных языков из базы данных
                                        $additionalLanguages->map(function ($lang) {
                                            return Forms\Components\Tabs\Tab::make($lang->name) // Например: English, Русский
                                            ->schema([
                                                Forms\Components\TextInput::make("translations.{$lang->code}.s1_title")->label("Заголовок секции ({$lang->code})"),
                                                Forms\Components\TextInput::make("translations.{$lang->code}.s1_subtitle")->label("Заголовок текста ({$lang->code})"),
                                                Forms\Components\RichEditor::make("translations.{$lang->code}.s1_text")->label("Текст секции ({$lang->code})"),
                                            ]);
                                        })->toArray())),
                            ]),

                        // ================== ВТОРАЯ СЕКЦИЯ ==================
                        Forms\Components\Tabs\Tab::make('Вторая секция')
                            ->schema([
                                Forms\Components\FileUpload::make('s2_image')->label('Фото (для цитаты)')->disk('public')->directory('about')->image()->required(),
                                Forms\Components\FileUpload::make('s2_signature')->label('Фото подписи')->disk('public')->directory('about')->image()->required(),

                                Forms\Components\Tabs::make('s2_lang_tabs')
                                    ->tabs(array_merge([
                                        Forms\Components\Tabs\Tab::make('Español (Основной)')
                                            ->schema([
                                                Forms\Components\Textarea::make('s2_quote')->label('Текст цитаты (ES)')->rows(4)->required(),
                                                Forms\Components\TextInput::make('s2_name')->label('Имя художника (ES)')->required(),
                                            ]),
                                    ], $additionalLanguages->map(function ($lang) {
                                        return Forms\Components\Tabs\Tab::make($lang->name)
                                            ->schema([
                                                Forms\Components\Textarea::make("translations.{$lang->code}.s2_quote")->label("Текст цитаты ({$lang->code})")->rows(4),
                                                Forms\Components\TextInput::make("translations.{$lang->code}.s2_name")->label("Имя художника ({$lang->code})"),
                                            ]);
                                    })->toArray())),
                            ]),

                        // ================== ТРЕТЬЯ СЕКЦИЯ ==================
                        Forms\Components\Tabs\Tab::make('Третья секция (Awards)')
                            ->schema([
                                Forms\Components\FileUpload::make('s3_logos')->label('Логотипы наград')->image()->multiple()->disk('public')->directory('about/logos')->required(),

                                Forms\Components\Tabs::make('s3_lang_tabs')
                                    ->tabs(array_merge([
                                        Forms\Components\Tabs\Tab::make('Español (Основной)')
                                            ->schema([
                                                Forms\Components\TextInput::make('s3_title')->label('Заголовок секции (ES)')->required(),
                                                Forms\Components\RichEditor::make('s3_text')->label('Текст под логотипами (ES)')->required(),
                                            ]),
                                    ], $additionalLanguages->map(function ($lang) {
                                        return Forms\Components\Tabs\Tab::make($lang->name)
                                            ->schema([
                                                Forms\Components\TextInput::make("translations.{$lang->code}.s3_title")->label("Заголовок секции ({$lang->code})"),
                                                Forms\Components\RichEditor::make("translations.{$lang->code}.s3_text")->label("Текст под логотипами ({$lang->code})"),
                                            ]);
                                    })->toArray())),
                            ]),
                    ])->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([])->actions([])->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            // Оставляем только страницу редактирования, привязанную к роутам
            'index' => Pages\EditAboutPage::route('/'),
            'create' => Pages\CreateAboutPage::route('/create'),
            'edit' => Pages\EditAboutPage::route('/{record}/edit'),
        ];
    }
}
