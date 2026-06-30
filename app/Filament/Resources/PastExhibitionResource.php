<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PastExhibitionResource\Pages;
use App\Models\PastExhibition;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PastExhibitionResource extends Resource
{
    protected static ?string $model = PastExhibition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'ВЫСТАВКИ';

    // Присваиваем номер 3 в меню
    protected static ?string $navigationLabel = '3. Прошедшие выставки';
    protected static ?string $pluralModelLabel = 'Прошедшие выставки';
    protected static ?string $modelLabel = 'выставку';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Название картины / выставки')
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->label('Маленькое описание под названием')
                        ->rows(3)
                        ->required(),

                    Forms\Components\FileUpload::make('image')
                        ->label('Фотография картины')
                        ->directory('past-exhibitions')
                        ->image()
                        ->required(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Порядок сортировки')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активно')
                            ->default(true),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Убрал метод square(), во второй версии он не нужен
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активно'),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPastExhibitions::route('/'),
            'create' => Pages\CreatePastExhibition::route('/create'),
            'edit' => Pages\EditPastExhibition::route('/{record}/edit'),
        ];
    }
}
