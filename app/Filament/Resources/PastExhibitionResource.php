<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PastExhibitionResource\Pages;
use App\Models\PastExhibition;
use App\Models\Language;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PastExhibitionResource extends Resource
{
    protected static ?string $model = PastExhibition::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'ВЫСТАВКИ';
    protected static ?string $navigationLabel = '3. Прошедшие выставки';
    protected static ?string $pluralModelLabel = 'Прошедшие выставки';
    protected static ?string $modelLabel = 'выставку';

    public static function form(Form $form): Form
    {
        // Динамически получаем все активные языки (кроме испанского оригинала)
        $languages = Language::where('code', '!=', 'es')->where('is_active', true)->get();

        $translationTabs = [];
        foreach ($languages as $lang) {
            $translationTabs[] = Forms\Components\Tabs\Tab::make($lang->name)
                ->schema([
                    Forms\Components\TextInput::make("translations.{$lang->code}.title")
                        ->label('Название картины / выставки'),

                    Forms\Components\Textarea::make("translations.{$lang->code}.description")
                        ->label('Маленькое описание под названием')
                        ->rows(3),
                ]);
        }

        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Название картины / выставки (Испанский)')
                        ->required(),

                    Forms\Components\Textarea::make('description')
                        ->label('Маленькое описание под названием (Испанский)')
                        ->rows(3)
                        ->required(),

                    Forms\Components\FileUpload::make('image')
                        ->label('Фотография картины')
                        ->disk('root')
                        ->directory('img/past-exhibitions')
                        ->image()
                        ->required(),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Порядок сортировки')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Активно')
                            ->default(true),
                    ]),

                    // Табы перевода
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
                Tables\Columns\ImageColumn::make('image')->label('Фото')->disk('root'),
                Tables\Columns\TextColumn::make('title')->label('Название')->searchable(),
                Tables\Columns\TextColumn::make('sort_order')->label('Порядок')->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')->label('Активно'),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (PastExhibition $record) {
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
            'index' => Pages\ListPastExhibitions::route('/'),
            'create' => Pages\CreatePastExhibition::route('/create'),
            'edit' => Pages\EditPastExhibition::route('/{record}/edit'),
        ];
    }
}
