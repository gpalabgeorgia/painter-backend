<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotificationResource\Pages;
use App\Models\Notification;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';
    protected static ?string $navigationLabel = 'Сообщения';
    protected static ?string $pluralModelLabel = 'Сообщения';
    protected static ?string $modelLabel = 'Сообщение';

    // Группируем или ставим над Контактами (как на скрине)
    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('sender', 'customer')
            ->where('is_read', false)
            ->count();

        return $count > 0 ? (string)$count : null;
    }

    // Отключаем возможность ручного создания сообщений через стандартную кнопку New
    public static function canCreate(): bool
    {
        return false;
    }

    // Показываем админу только сообщения от клиентов (ответы пользователей)
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('sender', 'customer')
            ->orderBy('created_at', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]); // Нам не нужна стандартная форма редактирования
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Имя клиента')
                    ->searchable()
                    ->getStateUsing(fn ($record) => ($record->customer->name ?? '') . ' ' . ($record->customer->last_name ?? '')),

                Tables\Columns\TextColumn::make('customer.email')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('message')
                    ->label('Текст сообщения')
                    ->limit(50),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Получено')
                    ->dateTime('d.m.Y H:i'),

                Tables\Columns\BooleanColumn::make('is_read')
                    ->label('Прочитано'),
            ])
            ->actions([
                // Модалка просмотра и ответа
                Action::make('view_and_reply')
                    ->label('Просмотреть')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Просмотр сообщения и ответ')
                    ->modalButton('Отправить ответ')
                    ->form(fn ($record) => [
                        Placeholder::make('customer_msg')
                            ->label('Сообщение от клиента:')
                            ->content(new HtmlString("
                                <div style='padding: 12px; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; color: #1f2937;'>
                                    <strong>Тема:</strong> {$record->title}<br><br>
                                    {$record->message}
                                </div>
                            ")),

                        Textarea::make('reply_message')
                            ->label('Ваш ответ пользователю')
                            ->placeholder('Напишите текст ответа...')
                            ->required()
                            ->rows(4),
                    ])
                    ->action(function ($record, array $data): void {
                        // Помечаем сообщение пользователя как прочитанное
                        $record->update(['is_read' => true]);

                        // Создаем системный ответ для пользователя
                        Notification::create([
                            'customer_id' => $record->customer_id,
                            'parent_id'   => $record->id,
                            'title'       => 'Ответ от администрации',
                            'message'     => $data['reply_message'],
                            'sender'      => 'system',
                            'type'        => 'info',
                            'is_read'     => false,
                        ]);
                    }),

                Tables\Actions\DeleteAction::make()->label('Удалить'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifications::route('/'),
        ];
    }
}
