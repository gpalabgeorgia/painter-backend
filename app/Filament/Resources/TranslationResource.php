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
        // 1. Получаем все активные языки
        $languages = Language::where('is_active', true)->get();

        if ($languages->isEmpty()) {
            return $form->schema([
                Forms\Components\Placeholder::make('warning')
                    ->label('Внимание')
                    ->content('Сначала добавьте хотя бы один язык в меню "Языки"!')
            ]);
        }

        $mainLang = $languages->first(); // Главный язык (Испанский)
        $otherLanguages = $languages->skip(1); // Все остальные языки, на которые нужно переводить (EN, RU...)

        // Первое поле — это и есть текст на испанском, он же ключ для базы
        $schema = [
            Forms\Components\TextInput::make('key')
                ->label("Текст на основном языке ({$mainLang->name})")
                ->placeholder('Например: Inicio, Contacto, Tienda...')
                ->required()
                ->disabled(fn ($livewire) => $livewire instanceof Pages\EditTranslation)
                ->columnSpan(2),
        ];

        // Генерируем поля ТОЛЬКО для переводов на другие языки
        foreach ($otherLanguages as $lang) {
            $schema[] = Forms\Components\TextInput::make("lang_{$lang->code}")
                ->label("Перевод на язык: {$lang->name} ({$lang->code})")
                ->placeholder('Введите перевод...')
                ->required()
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
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
