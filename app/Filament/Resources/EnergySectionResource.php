<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EnergySectionResource\Pages;
use App\Models\EnergySection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class EnergySectionResource extends Resource
{
    protected static ?string $model = EnergySection::class;
    protected static ?string $navigationIcon = 'heroicon-o-lightning-bolt';
    protected static ?string $navigationLabel = 'Главная: Energy секция';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Статус активности секции
                Forms\Components\Card::make()->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Секция активна и отображается на сайте')
                        ->default(true),
                ]),

                // Основной контент
                Forms\Components\Card::make()->schema([
                    Forms\Components\Textarea::make('title')
                        ->label('Главный большой заголовок')
                        ->rows(3)
                        ->required(),

                    Forms\Components\Textarea::make('text_1')
                        ->label('Текст (абзац 1)')
                        ->rows(4),

                    Forms\Components\Textarea::make('text_2')
                        ->label('Текст (абзац 2)')
                        ->rows(4),
                ]),

                // Скрытая заглушка для будущих полей (чтобы форма не ругалась)
                Forms\Components\Hidden::make('read_more_url'),
                Forms\Components\Hidden::make('instagram_count'),
                Forms\Components\Hidden::make('tumblr_count'),
                Forms\Components\Hidden::make('facebook_count'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активна'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->limit(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnergySections::route('/'),
            'create' => Pages\CreateEnergySection::route('/create'),
            'edit' => Pages\EditEnergySection::route('/{record}/edit'),
        ];
    }

    // Ограничиваем Singleton логикой (не более 1 записи)
    public static function canCreate(): bool
    {
        return EnergySection::count() < 1;
    }
}
