<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Notification;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Illuminate\Support\HtmlString;

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
                // Карточка со списком товаров в заказе
                Forms\Components\Card::make()
                    ->title('Состав заказа')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship('items') // Использует связь из модели Order
                            ->schema([
                                Forms\Components\TextInput::make('product_title')
                                    ->label('Название картины')
                                    ->disabled(), // Запрещаем редактировать название картины
                                Forms\Components\TextInput::make('price')
                                    ->label('Цена')
                                    ->numeric()
                                    ->prefix('€')
                                    ->disabled(), // Запрещаем редактировать цену
                            ])
                            ->columns(2)
                            ->disableItemCreation() // Админ не должен сам добавлять картины в заказ
                            ->disableItemDeletion() // Админ не должен удалять картины из заказа
                            ->disableItemMovement(),
                    ])->columnSpan(2),

                // Карточка управления статусом
                Forms\Components\Card::make()
                    ->title('Управление заказом')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Статус заказа')
                            ->options([
                                'new' => 'Новый',
                                'processing' => 'В обработке',
                                'completed' => 'Завершен',
                                'cancelled' => 'Отменен',
                            ])
                            ->required(),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    // Таблица вывода списка всех заказов
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('№ Заказа')
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Имя')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.last_name')
                    ->label('Фамилия')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.email')
                    ->label('Email'),

                // Считаем общую сумму заказа
                Tables\Columns\TextColumn::make('items_sum_price')
                    ->sum('items', 'price')
                    ->label('Сумма заказа')
                    ->getStateUsing(function ($record) {
                        // Берем сумму всех айтемов и форматируем вручную
                        $sum = $record->items->sum('price');
                        return '€' . number_format($sum, 2, '.', ' ');
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата покупки')
                    ->dateTime('d.m.Y H:i'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Статус')
                    ->colors([
                        'warning' => 'new',
                        'primary' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ]),
            ])
            ->actions([
                // Современная модалка с блоками товаров и сменой статуса
                Action::make('view_order')
                    ->label('Просмотр')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Детали заказа')
                    ->modalButton('Сохранить статус')
                    ->form(fn ($record) => [
                        // Блок со списком купленных продуктов
                        Placeholder::make('items_details')
                            ->label('Купленные картины:')
                            ->content(function () use ($record) {
                                $html = '<div class="space-y-3" style="margin-top: 10px;">';

                                foreach ($record->items as $item) {
                                    // Подтягиваем путь к картинке из связанного продукта
                                    $imagePath = $item->product && $item->product->image
                                        ? asset('img/products_img/' . $item->product->image)
                                        : 'https://placehold.co/80x80?text=No+Image';

                                    $html .= "
                                <div style='display: flex; align-items: center; justify-content: space-between; padding: 12px; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px;'>
                                    <div style='display: flex; align-items: center; gap: 15px;'>
                                        <img src='{$imagePath}' style='width: 60px; height: 60px; object-fit: cover; border-radius: 6px; border: 1px solid #d1d5db;' alt='' />
                                        <div>
                                            <div style='font-weight: 600; color: #1f2937;'>{$item->product_title}</div>
                                            <div style='font-size: 12px; color: #6b7280;'>ID товара: {$item->product_id}</div>
                                        </div>
                                    </div>
                                    <div style='font-weight: 700; color: #111827;'>
                                        €" . number_format($item->price, 2, '.', ' ') . "
                                    </div>
                                </div>";
                                }

                                $html .= '</div>';
                                return new HtmlString($html);
                            }),

                        // Поле изменения статуса прямо в этой же модалке
                        Select::make('status')
                            ->label('Статус заказа')
                            ->options([
                                'new' => 'Новый',
                                'processing' => 'В обработке',
                                'completed' => 'Завершен',
                                'cancelled' => 'Отменен',
                            ])
                            ->default($record->status)
                            ->required(),

                        // Показываем адрес доставки для информации
                        Placeholder::make('address_info')
                            ->label('Адрес доставки:')
                            ->content($record->delivery_address),
                    ])
                    // Сохраняем измененный статус при нажатии кнопки в модалке и создаем уведомление
                    ->action(function ($record, array $data): void {
                        $oldStatus = $record->status;
                        $newStatus = $data['status'];

                        if ($oldStatus !== $newStatus) {
                            $record->update([
                                'status' => $newStatus
                            ]);

                            $statuses = [
                                'new' => 'Новый',
                                'processing' => 'В обработке',
                                'completed' => 'Завершен',
                                'cancelled' => 'Отменен',
                            ];

                            $statusName = $statuses[$newStatus] ?? $newStatus;

                            // Просто создаем уведомление в базе. Без сокетов.
                            Notification::create([
                                'customer_id' => $record->customer_id,
                                'title' => "Обновление статуса заказа №{$record->id}",
                                'message' => "Статус вашего заказа успешно изменен на «{$statusName}».",
                                'type' => $newStatus === 'cancelled' ? 'danger' : ($newStatus === 'completed' ? 'success' : 'info'),
                                'is_read' => false,
                            ]);
                        }
                    }),
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
