<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExhibitionResource\Pages;
use App\Models\Exhibition;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ExhibitionResource extends Resource
{
    protected static ?string $model = Exhibition::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = '4. Выставки';
    protected static ?string $navigationGroup = 'Главная';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Активно на главной странице')
                        ->default(true),

                    Forms\Components\TextInput::make('date_range')
                        ->label('Даты проведения')
                        ->placeholder('Например: JUN 12 - JUL 16')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('title')
                        ->label('Название выставки')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->label('Короткое описание')
                        ->required()
                        ->rows(3),

                    Forms\Components\FileUpload::make('image')
                        ->label('Картина (Изображение)')
                        ->image()
                        ->disk('root')
                        ->directory('public/img/exhibitions')
                        ->required(fn ($record) => $record === null) // Обязательно только при создании
                        ->dehydrated(fn ($state) => filled($state)), // Не перезаписывает null при редактировании
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Используем ViewColumn — он берёт наш кастомный Blade и рендерит его без ограничений Filament
                Tables\Columns\ViewColumn::make('image')
                    ->label('Картина')
                    ->view('filament.tables.columns.exhibition-image'),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активно'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_range')
                    ->label('Даты'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExhibitions::route('/'),
            'create' => Pages\CreateExhibition::route('/create'),
            'edit' => Pages\EditExhibition::route('/{record}/edit'),
        ];
    }
}
