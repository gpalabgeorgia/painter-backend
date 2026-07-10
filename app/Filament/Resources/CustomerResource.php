<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables;
use Filament\Notifications\Notification;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Клиенты';
    protected static ?string $modelLabel = 'Клиент';
    protected static ?string $pluralModelLabel = 'Клиенты';

    // Отключаем глобально возможность создания записей через админку
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        // Форма пустая, так как админ только просматривает список и управляет кнопками
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar')
                    ->rounded()
                    ->label('Фото'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Имя'),

                TextColumn::make('last_name')
                    ->searchable()
                    ->sortable()
                    ->label('Фамилия'),

                TextColumn::make('email')
                    ->searchable()
                    ->label('Эл. почта'),

                TextColumn::make('addresses.phone')
                    ->label('Телефон')
                    ->default('Не указан')
                    // Очищаем массив от пустых значений и убираем дубликаты номеров
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', array_unique(array_filter($state))) : $state),

                TextColumn::make('warning_count')
                    ->sortable()
                    ->label('Предупреждения')
                    ->alignCenter(),

                BadgeColumn::make('status')
                    ->label('Статус')
                    ->enum([
                        'active' => 'Активен',
                        'banned' => 'Заблокирован',
                    ])
                    ->colors([
                        'success' => 'active',
                        'danger' => 'banned',
                    ]),

                TextColumn::make('created_at')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->label('Дата регистрации'),
            ])
            ->filters([])
            ->actions([
                // 1. Действие: Предупреждение
                Action::make('warn')
                    ->label('Предупредить')
                    ->icon('heroicon-o-exclamation')
                    ->color('warning')
                    ->action(function (Customer $record) {
                        $record->increment('warning_count');

                        Notification::make()
                            ->title('Предупреждение вынесено')
                            ->body("У пользователя теперь {$record->warning_count} преедпреждений.")
                            ->success()
                            ->send();
                    }),

                // 2. Действие: Блокировка / Разблокировка
                Action::make('toggle_ban')
                    ->label(fn (Customer $record): string => $record->status === 'banned' ? 'Разблокировать' : 'Заблокировать')
                    ->icon(fn (Customer $record): string => $record->status === 'banned' ? 'heroicon-o-lock-open' : 'heroicon-o-lock-closed')
                    ->color(fn (Customer $record): string => $record->status === 'banned' ? 'success' : 'danger')
                    ->requiresConfirmation()
                    ->action(function (Customer $record) {
                        if ($record->status === 'banned') {
                            $record->update(['status' => 'active']);
                            $statusText = 'разблокирован';
                        } else {
                            $record->update(['status' => 'banned']);
                            $statusText = 'заблокирован';
                        }

                        Notification::make()
                            ->title("Пользователь {$statusText}")
                            ->success()
                            ->send();
                    }),

                // 3. Стандартное удаление
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
        // Убрали страницы создания и редактирования. Оставили только список клиентов
        return [
            'index' => Pages\ListCustomers::route('/'),
        ];
    }
}
