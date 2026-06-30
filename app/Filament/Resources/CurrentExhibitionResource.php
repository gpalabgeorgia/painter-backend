<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CurrentExhibitionResource\Pages;
use App\Models\CurrentExhibition;
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

    // Добавил номер «1. » в название пункта меню
    protected static ?string $navigationLabel = '1. Текущая выставка';
    protected static ?string $pluralModelLabel = 'Текущая выставка';
    protected static ?string $modelLabel = 'настройки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Отображать секцию текущей выставки на сайте')
                        ->default(true)
                        ->columnSpan('full'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('page_title')
                            ->label('Название страницы (заголовок сверху)')
                            ->required(),

                        Forms\Components\TextInput::make('subtitle')
                            ->label('Маленький текст слева (над названием)')
                            ->required(),
                    ]),

                    Forms\Components\TextInput::make('title')
                        ->label('Название выставки')
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
                        ->label('Короткое описание (справа)')
                        ->rows(4)
                        ->required(),

                    Forms\Components\FileUpload::make('bg_image')
                        ->label('Фоновое изображение баннера')
                        ->directory('exhibitions')
                        ->image(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('page_title')->label('Заголовок страницы'),
                Tables\Columns\TextColumn::make('title')->label('Название выставки'),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активно'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCurrentExhibitions::route('/'),
        ];
    }
}
