<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'МАГАЗИН';
    protected static ?string $navigationLabel = 'Все картины';
    protected static ?string $pluralModelLabel = 'Картины';
    protected static ?string $modelLabel = 'картину';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)->schema([
                    // Левая колонка для текстов и цены (занимает 2 части из 3)
                    Forms\Components\Card::make()->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Название картины')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Второстепенное название (категория/стиль)')
                            ->maxLength(255)
                            ->placeholder('Например: Abstract, Landscape'),

                        Forms\Components\TextInput::make('price')
                            ->label('Цена (€)')
                            ->numeric()
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->decimalPlaces(2) // 2 знака после запятой для центов
                                ->decimalSeparator('.') // точка как разделитель копеек
                                ->thousandsSeparator(' ') // пробел как разделитель тысяч
                                ->normalizeZeros(false)
                            )
                            ->required()
                            ->placeholder('0.00'),
                    ])->columnSpan(2),

                    // Правая колонка для изображения и статуса (занимает 1 часть из 3)
                    Forms\Components\Card::make()->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Изображение картины')
                            ->image()
                            ->disk('products_public') // Сохраняем в public/img/products_img
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Отображать в магазине')
                            ->default(true),
                    ])->columnSpan(1),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото')
                    ->disk('products_public'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Второстепенное название')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->getStateUsing(fn ($record) => '€ ' . number_format($record->price, 2, '.', ' '))
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активен'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Добавлен')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Здесь фильтры пока не нужны
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
