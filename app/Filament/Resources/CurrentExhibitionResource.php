<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrentExhibitionResource\Pages;
use App\Models\CurrentExhibition;
use App\Models\Language;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class CurrentExhibitionResource extends Resource
{
    protected static ?string $model = CurrentExhibition::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'ВЫСТАВКИ';
    protected static ?string $navigationLabel = '1. Текущая выставка';
    protected static ?string $pluralModelLabel = 'Текущая выставка';
    protected static ?string $modelLabel = 'настройки';

    public static function form(Form $form): Form
    {
        // Динамически получаем все языки для вкладок (кроме испанского оригинала)
        $languages = Language::where('code', '!=', 'es')->where('is_active', true)->get();

        $translationTabs = [];
        foreach ($languages as $lang) {
            $translationTabs[] = Forms\Components\Tabs\Tab::make($lang->name)
                ->schema([
                    Forms\Components\TextInput::make("translations.{$lang->code}.page_title")
                        ->label('Название страницы (заголовок сверху)'),

                    Forms\Components\TextInput::make("translations.{$lang->code}.subtitle")
                        ->label('Маленький текст слева'),

                    Forms\Components\TextInput::make("translations.{$lang->code}.title")
                        ->label('Название выставки'),

                    Forms\Components\Textarea::make("translations.{$lang->code}.description")
                        ->label('Короткое описание')
                        ->rows(4),
                ]);
        }

        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Отображать секцию текущей выставки на сайте')
                        ->default(true)
                        ->columnSpan('full'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('page_title')
                            ->label('Название страницы (Испанский)')
                            ->required(),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Маленький текст слева (Испанский)')
                            ->required(),
                    ]),

                    Forms\Components\TextInput::make('title')
                        ->label('Название выставки (Испанский)')
                        ->required(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Дата начала')
                            ->required(),

                        Forms\Components\DatePicker::make('end_date')
                            ->label('Дата окончания')
                            ->required(),
                    ]),

                    Forms\Components\Textarea::make('description')
                        ->label('Короткое описание (Испанский)')
                        ->rows(4)
                        ->required(),

                    Forms\Components\FileUpload::make('bg_image')
                        ->label('Фоновое изображение баннера')
                        ->directory('exhibitions')
                        ->image(),

                    // Добавляем табы с переводами в самый конец формы
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
                Tables\Columns\TextColumn::make('page_title')->label('Заголовок страницы'),
                Tables\Columns\TextColumn::make('title')->label('Название выставки'),
                Tables\Columns\BooleanColumn::make('is_active')->label('Активно'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    // Наполняем форму переводами при клике на Edit
                    ->mutateRecordDataUsing(function (CurrentExhibition $record, array $data): array {
                        $data['translations'] = $record->translations;
                        return $data;
                    })
                    // Кастомное сохранение основных полей и связанных переводов
                    ->using(function (CurrentExhibition $record, array $data): CurrentExhibition {
                        $translations = $data['translations'] ?? [];
                        unset($data['translations']);

                        // 1. Обновляем саму выставку
                        $record->update($data);

                        // 2. Сохраняем переводы в базу
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
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCurrentExhibitions::route('/'),
        ];
    }
}
