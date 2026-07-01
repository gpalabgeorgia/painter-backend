<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-mail';
    protected static ?string $navigationGroup = 'КОНТАКТЫ';
    protected static ?string $navigationLabel = 'Сообщения с формы';
    protected static ?string $pluralModelLabel = 'Сообщения с формы';
    protected static ?string $modelLabel = 'сообщение';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Имя отправителя')
                        ->disabled(),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->disabled(),

                    Forms\Components\TextInput::make('subject')
                        ->label('Тема сообщения')
                        ->disabled(),

                    Forms\Components\Textarea::make('message')
                        ->label('Текст сообщения')
                        ->rows(6)
                        ->disabled(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата получения')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->label('Тема')
                    ->searchable()
                    ->limit(30),
            ])
            ->defaultSort('created_at', 'desc') // Свежие сообщения всегда сверху
            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(), // Кнопка "Просмотр" вместо "Редактировать"
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
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}
