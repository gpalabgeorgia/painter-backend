<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogoSettingResource\Pages;
use App\Filament\Resources\LogoSettingResource\RelationManagers;
use App\Models\LogoSetting;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogoSettingResource extends Resource
{
    protected static ?string $model = LogoSetting::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = '1. Логотип';
    protected static ?string $navigationGroup = 'Хедер';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\FileUpload::make('header_logo')
                        ->label('Роспись художника (Для Хедера)')
                        ->disk('public')
                        ->directory('logos')
                        ->image(),

                    Forms\Components\FileUpload::make('footer_logo')
                        ->label('Роспись художника (Для Футера)')
                        ->disk('public')
                        ->directory('logos')
                        ->image(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('header_logo')
                    ->label('Лого Хедера')
                    ->disk('public'),

                Tables\Columns\ImageColumn::make('footer_logo')
                    ->label('Лого Футера')
                    ->disk('public'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Изменено')
                    ->dateTime('d.m.Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Удаляем bulk actions, чтобы случайно не удалить единственную настройку
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLogoSettings::route('/'),
            'create' => Pages\CreateLogoSetting::route('/create'),
            'edit' => Pages\EditLogoSetting::route('/{record}/edit'),
        ];
    }
}
