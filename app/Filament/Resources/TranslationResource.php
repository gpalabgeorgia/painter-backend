<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TranslationResource\Pages;
use App\Models\Language;
use App\Models\Translation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class TranslationResource extends Resource
{
    protected static ?string $model = Translation::class;

    protected static ?string $navigationIcon = 'heroicon-o-translate';

    public static function form(Form $form): Form
    {
        $languages = Language::where('is_active', true)->get();

        if ($languages->isEmpty()) {
            return $form->schema([
                Forms\Components\Placeholder::make('warning')
                    ->label('Внимание')
                    ->content('Сначала добавьте хотя бы один язык в меню "Языки"!')
            ]);
        }

        $mainLang = $languages->first();
        $otherLanguages = $languages->skip(1);

        $schema = [
            Forms\Components\TextInput::make('key')
                ->label("Текст на основном языке ({$mainLang->name})")
                ->placeholder('Например: Inicio, Contacto, Tienda...')
                ->required()
                ->disabled(fn ($livewire) => $livewire instanceof Pages\EditTranslation)
                ->columnSpan(2),
        ];

        foreach ($otherLanguages as $lang) {
            $schema[] = Forms\Components\TextInput::make("lang_{$lang->code}")
                ->label("Перевод на язык: {$lang->name} ({$lang->code})")
                ->placeholder('Введите перевод...')
                ->afterStateHydrated(function ($component, $state, $record) use ($lang) {
                    if ($record) {
                        $translation = Translation::where('key', $record->key)
                            ->where('lang_code', $lang->code)
                            ->first();
                        $component->state($translation?->value);
                    }
                });
        }

        return $form->schema($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('lang_code')->label('Язык'),
                Tables\Columns\TextColumn::make('value')->label('Текст')->limit(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Кнопка удаления: перед удалением строки она стирает этот ключ для ВСЕХ языков
                Tables\Actions\DeleteAction::make()
                    ->before(function (Translation $record) {
                        Translation::where('key', $record->key)->delete();
                    }),
            ])
            ->bulkActions([
                // Массовое удаление чекбоксами тоже очистит все связанные ключи
                Tables\Actions\DeleteBulkAction::make()
                    ->before(function (\Illuminate\Database\Eloquent\Collection $records) {
                        $keys = $records->pluck('key')->unique()->toArray();
                        Translation::whereIn('key', $keys)->delete();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslations::route('/'),
            'create' => Pages\CreateTranslation::route('/create'),
            'edit' => Pages\EditTranslation::route('/{record}/edit'),
        ];
    }
}
