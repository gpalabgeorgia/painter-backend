<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Администратор';
    protected static ?string $pluralModelLabel = 'Администраторы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Имя')
                        ->required(),

                    Forms\Components\TextInput::make('last_name')
                        ->label('Фамилия'),

                    Forms\Components\TextInput::make('email')
                        ->label('Эл. почта')
                        ->email()
                        ->required()
                        ->unique(table: 'users', column: 'email', ignoreRecord: true),

                    Forms\Components\TextInput::make('phone')
                        ->label('Телефон')
                        ->tel(),

                    // Поле изменения пароля — без fn, на чистых замыканиях
                    Forms\Components\TextInput::make('password')
                        ->label('Пароль')
                        ->password()
                        ->dehydrateStateUsing(function ($state) {
                            return !empty($state) ? Hash::make($state) : null;
                        })
                        ->dehydrated(function ($state) {
                            return !empty($state);
                        })
                        ->required(function (string $context): bool {
                            return $context === 'create';
                        }),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Имя')->searchable(),
                Tables\Columns\TextColumn::make('last_name')->label('Фамилия')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Email')->searchable(),
                Tables\Columns\TextColumn::make('phone')->label('Телефон'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

                // Кнопка восстановления пароля (отправка ссылки на email)
                Tables\Actions\Action::make('sendPasswordReset')
                    ->label('Восстановить пароль')
                    ->icon('heroicon-o-mail')
                    ->color('warning')
                    ->action(function (User $record) {
                        $token = app('auth.password.broker')->createToken($record);
                        $record->sendPasswordResetNotification($token);

                        \Filament\Notifications\Notification::make()
                            ->title('Ссылка для восстановления отправлена')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
