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
    protected static ?string $navigationLabel = 'Контакты и соц. сети';

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
                        ->reactive() // Делает поле реактивным для валидации
                        ->rules([
                            function (Closure $get, $record) {
                                return function (string $attribute, $value, Closure $fail) use ($get, $record) {
                                    // Если выбран тип "Телефон"
                                    if ($value === 'phone') {
                                        $query = HeaderContact::where('type', 'phone');

                                        // Если мы редактируем уже существующий телефон, исключаем его из счета
                                        if ($record) {
                                            $query->where('id', '!=', $record->id);
                                        }

                                        // Если в базе уже есть 2 телефона, выдаем ошибку
                                        if ($query->count() >= 2) {
                                            $fail('Нельзя добавить больше двух номеров телефона.');
                                        }
                                    }
                                };
                            },
                        ]),

                    Forms\Components\TextInput::make('value')
                        ->label('Значение / Ссылка')
                        ->required()
                        ->placeholder('Например: +7999... или https://instagram.com/...'),

                    Forms\Components\TextInput::make('label')
                        ->label('Название (необязательно)')
                        ->placeholder('Например: Основной телефон'),

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
                    ->searchable(),

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
