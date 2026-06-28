<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutPageResource\Pages;
use App\Models\AboutPage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class AboutPageResource extends Resource
{
    protected static ?string $model = AboutPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Страница О нас';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Heading')
                    ->tabs([
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
                        Forms\Components\Tabs\Tab::make('Вторая секция')->schema([]),
                        Forms\Components\Tabs\Tab::make('Третья секция')->schema([]),
                    ])->columnSpan('full'), // <--- Вот здесь поправили
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([])->actions([])->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            // Мы УДАЛИЛИ строчку 'index' => Pages\ListAboutPages::route('/'),
            // Теперь корень ресурса ('/') сразу ведет на редактирование записи с ID 1
            'index' => Pages\EditAboutPage::route('/'),
            'create' => Pages\CreateAboutPage::route('/create'),
            'edit' => Pages\EditAboutPage::route('/{record}/edit'),
        ];
    }
}
