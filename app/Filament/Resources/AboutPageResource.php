<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPageResource\Pages;
use App\Models\AboutPage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

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
        return $form
            ->schema([
                Forms\Components\Tabs::make('Heading')
                    ->tabs([
                        // Первая секция
                        Forms\Components\Tabs\Tab::make('Первая секция')
                            ->schema([
                                Forms\Components\TextInput::make('s1_title')
                                    ->label('Заголовок секции')
                                    ->placeholder('Например: Биография')
                                    ->required(),

                                Forms\Components\FileUpload::make('s1_image')
                                    ->label('Фото художника')
                                    ->disk('public')
                                    ->directory('about')
                                    ->image()
                                    ->required(),

                                Forms\Components\TextInput::make('s1_subtitle')
                                    ->label('Заголовок текста')
                                    ->placeholder('Например: Заза Папидзе')
                                    ->required(),

                                Forms\Components\RichEditor::make('s1_text')
                                    ->label('Текст секции')
                                    ->required(),
                            ]),

                        // Вторая секция
                        Forms\Components\Tabs\Tab::make('Вторая секция')
                            ->schema([
                                Forms\Components\FileUpload::make('s2_image')
                                    ->label('Фото художника (для цитаты)')
                                    ->disk('public')
                                    ->directory('about')
                                    ->image()
                                    ->required(),

                                Forms\Components\Textarea::make('s2_quote')
                                    ->label('Текст цитаты')
                                    ->rows(4)
                                    ->required(),

                                Forms\Components\FileUpload::make('s2_signature')
                                    ->label('Фото подписи (SVG или PNG)')
                                    ->disk('public')
                                    ->directory('about')
                                    ->image()
                                    ->required(),

                                Forms\Components\TextInput::make('s2_name')
                                    ->label('Имя художника')
                                    ->placeholder('Например: Zaza Papidze')
                                    ->required(),
                            ]),

                        // Третья секция (Заполнили полями под твою верстку)
                        Forms\Components\Tabs\Tab::make('Третья секция (Awards)')
                            ->schema([
                                Forms\Components\TextInput::make('s3_title')
                                    ->label('Заголовок секции')
                                    ->placeholder('Например: Awards')
                                    ->required(),

                                Forms\Components\FileUpload::make('s3_logos')
                                    ->label('Логотипы наград (выберите сразу несколько штук)')
                                    ->image()
                                    ->multiple()
                                    ->disk('public')
                                    ->directory('about/logos')
                                    ->required(),

                                Forms\Components\RichEditor::make('s3_text')
                                    ->label('Текст под логотипами')
                                    ->required(),
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
