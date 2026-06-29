<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtworksPageResource\Pages;
use App\Models\ArtworksPage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

class ArtworksPageResource extends Resource
{
    protected static ?string $model = ArtworksPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = 'Страница Artworks';

    // Ссылка из меню сразу ведет на редактирование записи с ID = 1
    public static function getNavigationUrl(): string
    {
        return static::getUrl('edit', ['record' => 1]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Artworks Page Tabs')
                    ->tabs([
                        // Первая секция (по твоему макету image_40a5aa.png)
                        Forms\Components\Tabs\Tab::make('Первая секция')
                            ->schema([
                                Forms\Components\TextInput::make('s1_title')
                                    ->label('Главный заголовок секции')
                                    ->placeholder('Например: Artworks')
                                    ->required(),

                                Forms\Components\FileUpload::make('s1_image')
                                    ->label('Изображение (Картина)')
                                    ->disk('public')
                                    ->directory('artworks')
                                    ->image()
                                    ->required(),

                                Forms\Components\TextInput::make('s1_subtitle')
                                    ->label('Название картины под изображением')
                                    ->placeholder('Например: Conversation')
                                    ->required(),

                                Forms\Components\Textarea::make('s1_text')
                                    ->label('Текст описания картины')
                                    ->rows(4)
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
            // Перемапливаем роуты сразу на страницу редактирования
            'index' => Pages\EditArtworksPage::route('/'),
            'create' => Pages\CreateArtworksPage::route('/create'),
            'edit' => Pages\EditArtworksPage::route('/{record}/edit'),
        ];
    }
}
