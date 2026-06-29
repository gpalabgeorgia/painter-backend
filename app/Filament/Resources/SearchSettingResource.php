<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SearchSettingResource\Pages;
use App\Models\SearchSetting;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SearchSettingResource extends Resource
{
    protected static ?string $model = SearchSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = '1. Настройки поиска';
    protected static ?string $navigationGroup = 'Настройки сайта';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок страницы поиска')
                        ->required(),

                    Forms\Components\TextInput::make('no_results_title')
                        ->label('Заголовок "Ничего не найдено"')
                        ->required(),

                    Forms\Components\Textarea::make('no_results_text')
                        ->label('Текст-подсказка при отсутствии результатов')
                        ->rows(3)
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок страницы'),
                Tables\Columns\TextColumn::make('no_results_title')
                    ->label('Заголовок "Пусто"'),
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
            'index' => Pages\ListSearchSettings::route('/'),
            'create' => Pages\CreateSearchSetting::route('/create'),
            'edit' => Pages\EditSearchSetting::route('/{record}/edit'),
        ];
    }

    // Запрещаем создавать кнопку "Создать", если в базе уже есть 1 запись
    public static function canCreate(): bool
    {
        return SearchSetting::count() < 1;
    }
}
