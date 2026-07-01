<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderContactResource\Pages;
use App\Models\HeaderContact;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Closure;

class HeaderContactResource extends Resource
{
    protected static ?string $model = HeaderContact::class;
    protected static ?string $navigationIcon = 'heroicon-o-phone';
    protected static ?string $navigationLabel = '2. Контакты и соц. сети';
    protected static ?string $navigationGroup = 'Хедер';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('type')
                        ->label('Тип контакта')
                        ->options([
                            'phone' => 'Телефон',
                            'email' => 'Эл. почта',
                            // ДОБАВИЛИ НОВЫЕ ТИПЫ ДЛЯ СТРАНИЦЫ КОНТАКТОВ:
                            'address' => 'Физический адрес',
                            'contact_title' => 'Контакты: Заголовок (Get in touch)',
                            'contact_description' => 'Контакты: Описание под заголовком',
                            // Соц. сети:
                            'instagram' => 'Instagram',
                            'facebook' => 'Facebook',
                            'twitter' => 'Twitter (X)',
                            'telegram' => 'Telegram',
                            'youtube' => 'YouTube',
                            'tiktok' => 'TikTok',
                            'pinterest' => 'Pinterest',
                            'whatsapp' => 'WhatsApp',
                            'linkedin' => 'LinkedIn',
                        ])
                        ->required()
                        ->reactive()
                        ->rules([
                            function (Closure $get, $record) {
                                return function (string $attribute, $value, Closure $fail) use ($get, $record) {
                                    if ($value === 'phone') {
                                        $query = HeaderContact::where('type', 'phone');
                                        if ($record) {
                                            $query->where('id', '!=', $record->id);
                                        }
                                        if ($query->count() >= 2) {
                                            $fail('Нельзя добавить больше двух номеров телефона.');
                                        }
                                    }

                                    // Ограничим заголовки и описания страниц одной записью, чтобы не дублировать
                                    if (in_array($value, ['address', 'contact_title', 'contact_description'])) {
                                        $query = HeaderContact::where('type', $value);
                                        if ($record) {
                                            $query->where('id', '!=', $record->id);
                                        }
                                        if ($query->count() >= 1) {
                                            $fail('Этот элемент уже добавлен в базу.');
                                        }
                                    }
                                };
                            },
                        ]),

                    Forms\Components\TextInput::make('value')
                        ->label('Значение / Ссылка / Текст')
                        ->required()
                        ->placeholder(function (Closure $get) {
                            $type = $get('type');
                            if ($type === 'contact_description') return 'Введите текст описания...';
                            if ($type === 'address') return 'Например: 123 Demo St, New Orleans...';
                            return 'Например: +7999... или https://instagram.com/...';
                        }),

                    Forms\Components\TextInput::make('label')
                        ->label('Название (необязательно)')
                        ->placeholder('Например: Основной адрес или Рабочий email'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Активно')
                        ->default(true),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип')
                    ->enum([
                        'phone' => 'Телефон',
                        'email' => 'Эл. почта',
                        'address' => 'Физический адрес',
                        'contact_title' => 'Контакты: Заголовок',
                        'contact_description' => 'Контакты: Описание',
                        'instagram' => 'Instagram',
                        'facebook' => 'Facebook',
                        'twitter' => 'Twitter (X)',
                        'telegram' => 'Telegram',
                        'youtube' => 'YouTube',
                        'tiktok' => 'TikTok',
                        'pinterest' => 'Pinterest',
                        'whatsapp' => 'WhatsApp',
                        'linkedin' => 'LinkedIn',
                    ]),

                Tables\Columns\TextColumn::make('value')
                    ->label('Значение')
                    ->searchable()
                    ->limit(50), // Чтобы длинное описание не разносило таблицу

                Tables\Columns\TextColumn::make('label')
                    ->label('Метка'),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Статус'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeaderContacts::route('/'),
            'create' => Pages\CreateHeaderContact::route('/create'),
            'edit' => Pages\EditHeaderContact::route('/{record}/edit'),
        ];
    }
}
