<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PastExhibitionHeaderResource\Pages;
use App\Models\PastExhibitionHeader;
use App\Models\Language;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PastExhibitionHeaderResource extends Resource
{
    protected static ?string $model = PastExhibitionHeader::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments';
    protected static ?string $navigationGroup = 'ВЫСТАВКИ';
    protected static ?string $navigationLabel = '4. Заголовки прошедших';
    protected static ?string $pluralModelLabel = 'Заголовки секции';
    protected static ?string $modelLabel = 'настройки заголовков';

    public static function form(Form $form): Form
    {
        // Динамически получаем все активные языки кроме испанского
        $languages = Language::where('code', '!=', 'es')->where('is_active', true)->get();

        $translationTabs = [];
        foreach ($languages as $lang) {
            $translationTabs[] = Forms\Components\Tabs\Tab::make($lang->name)
                ->schema([
                    Forms\Components\TextInput::make("translations.{$lang->code}.section_title")
                        ->label('Заголовок всей секции (слева)'),

                    Forms\Components\Textarea::make("translations.{$lang->code}.section_description")
                        ->label('Короткий текст всей секции (справа)')
                        ->rows(3),
                ]);
        }

        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('section_title')
                            ->label('Заголовок всей секции (Испанский)')
                            ->required(),

                        Forms\Components\Textarea::make('section_description')
                            ->label('Короткий текст всей секции (Испанский)')
                            ->rows(3)
                            ->required(),
                    ]),

                    // Добавляем табы с переводами
                    Forms\Components\Tabs::make('Переводы')
                        ->tabs($translationTabs)
                        ->columnSpan('full')
                        ->hidden(empty($translationTabs)),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('section_title')
                    ->label('Заголовок секции'),
                Tables\Columns\TextColumn::make('section_description')
                    ->label('Текст справа')
                    ->limit(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    // Заполняем форму переводами
                    ->mutateRecordDataUsing(function (PastExhibitionHeader $record, array $data): array {
                        $data['translations'] = $record->translations;
                        return $data;
                    })
                    // Перехватываем сохранение модалки
                    ->using(function (PastExhibitionHeader $record, array $data): PastExhibitionHeader {
                        $translations = $data['translations'] ?? [];
                        unset($data['translations']);

                        // 1. Обновляем основные поля
                        $record->update($data);

                        // 2. Пишем переводы в content_translations
                        foreach ($translations as $locale => $fields) {
                            if (!is_array($fields)) continue;

                            foreach ($fields as $field => $value) {
                                if ($value !== null && $value !== '') {
                                    $record->contentTranslations()->updateOrCreate(
                                        ['lang_code' => $locale, 'field' => $field],
                                        ['value' => $value]
                                    );
                                } else {
                                    $record->contentTranslations()
                                        ->where('lang_code', $locale)
                                        ->where('field', $field)
                                        ->delete();
                                }
                            }
                        }

                        return $record;
                    }),
                Tables\Actions\DeleteAction::make()
                    // При удалении заголовков чистим и связанные переводы
                    ->before(function (PastExhibitionHeader $record) {
                        $record->contentTranslations()->delete();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->before(function (\Illuminate\Database\Eloquent\Collection $records) {
                        foreach ($records as $record) {
                            $record->contentTranslations()->delete();
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePastExhibitionHeaders::route('/'),
        ];
    }
}
