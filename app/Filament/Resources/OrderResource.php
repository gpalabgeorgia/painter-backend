<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $pluralModelLabel = 'Заказы';
    protected static ?string $modelLabel = 'Заказ';

    public static function canCreate(): bool
    {
        return false;
    }

    // Форма просмотра заказа и редактирования статуса
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Placeholder::make('customer_name')
                            ->label('Покупатель')
                            ->content(fn ($record): string => $record && $record->customer ? "{$record->customer->first_name} {$record->customer->last_name}" : '—'),

                        Forms\Components\Placeholder::make('customer_email')
                            ->label('Email')
                            ->content(fn ($record): string => $record && $record->customer ? ($record->customer->email ?? '—') : '—'),

                        Forms\Components\Placeholder::make('customer_phone')
                            ->label('Номер телефона')
                            ->content(fn ($record): string => $record && $record->customer ? ($record->customer->phone ?? '—') : '—'),

                        Forms\Components\Placeholder::make('created_at')
                            ->label('Дата покупки')
                            ->content(fn ($record): string => $record && $record->created_at ? $record->created_at->format('d.m.Y H:i') : '—'),

                        Forms\Components\Textarea::make('delivery_address')
                            ->label('Полный адрес доставки')
                            ->disabled() // Блокируем изменение адреса, чтобы менеджер ничего случайно не стёр
                            ->rows(3)
                            ->columnSpan('full'),

                        Forms\Components\Select::make('status')
                            ->label('Статус заказа')
                            ->required()
                            ->options([
                                'new' => 'Новый',
                                'active' => 'Активный',
                                'completed' => 'Завершенный',
                            ])
                            ->columnSpan('full'),
                    ])->columns(2)
            ]);
    }

    // Таблица вывода списка всех заказов
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer.last_name')
                    ->label('Фамилия')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer.email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.phone')
                    ->label('Телефон')
                    ->searchable()
                    ->default('—'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата покупки')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('delivery_address')
                    ->label('Адрес доставки')
                    ->limit(40),

                // Статус-badge под Filament v2
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус')
                    ->enum([
                        'new' => 'Новый',
                        'active' => 'Активный',
                        'completed' => 'Завершенный',
                    ])
                    ->colors([
                        'danger' => 'new',       // Красный
                        'warning' => 'active',   // Жёлтый
                        'success' => 'completed', // Зелёный
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'new' => 'Новые',
                        'active' => 'Активные',
                        'completed' => 'Завершенные',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
