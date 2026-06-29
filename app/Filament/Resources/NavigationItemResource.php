<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationItemResource\Pages;
use App\Models\NavigationItem;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class NavigationItemResource extends Resource
{
    protected static ?string $model = NavigationItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-menu';
    protected static ?string $navigationLabel = '3. Меню навигации';
    protected static ?string $navigationGroup = 'Хедер';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('label')
                        ->label('Название ссылки')
                        ->required()
                        ->placeholder('Например: HOME, ABOUT'),

                    Forms\Components\TextInput::make('url')
                        ->label('Ссылка (URL)')
                        ->required()
                        ->placeholder('Например: / или /about'),

                    Forms\Components\TextInput::make('sort')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->required(),

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
                Tables\Columns\TextColumn::make('label')
                    ->label('Название')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('url')
                    ->label('Ссылка'),

                Tables\Columns\TextColumn::make('sort')
                    ->label('Порядок')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Статус'),
            ])
            ->filters([
                // Здесь можно добавить фильтры, если понадобятся
            ])
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
            'index' => Pages\ListNavigationItems::route('/'),
            'create' => Pages\CreateNavigationItem::route('/create'),
            'edit' => Pages\EditNavigationItem::route('/{record}/edit'),
        ];
    }
}
