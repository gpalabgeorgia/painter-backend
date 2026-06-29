<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtworkItemResource\Pages;
use App\Models\ArtworkItem;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ArtworkItemResource extends Resource
{
    protected static ?string $model = ArtworkItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-photograph';
    protected static ?string $navigationLabel = '2. Карточки картин';
    protected static ?string $navigationGroup = 'Галерея (Artworks)';
    protected static ?int $navigationSort = 2;
    protected static ?string $pluralLabel = 'Карточки картин для страницы Artworks';
    protected static ?string $modelLabel = 'картину';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Название картины')
                        ->required(),

                    Forms\Components\FileUpload::make('image')
                        ->label('Изображение')
                        ->disk('public')
                        ->directory('artworks-grid')
                        ->image()
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->label('Короткое описание')
                        ->rows(3)
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото')
                    ->disk('public')
                    ->width(50)  // Задаем фиксированную ширину
                    ->height(50), // Задаем такую же высоту, чтобы получился квадрат

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable() // Поиск!
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->limit(60),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Удаление прямо из строки!
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArtworkItems::route('/'),
            'create' => Pages\CreateArtworkItem::route('/create'),
            'edit' => Pages\EditArtworkItem::route('/{record}/edit'),
        ];
    }
}
