<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoSectionResource\Pages;
use App\Models\PromoSection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

class PromoSectionResource extends Resource
{
    protected static ?string $model = PromoSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = '6. Промо / Обучение';
    protected static ?string $navigationGroup = 'Главная';
    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Изображение художника')
                        ->disk('public')      // Используем стандартный безопасный диск public
                        ->directory('promo')  // Файлы будут лежать в storage/app/public/promo
                        ->image()
                        ->required(),

                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок секции')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->label('Описание')
                        ->required()
                        ->rows(4),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('button_text')
                            ->label('Текст кнопки')
                            ->required(),

                        Forms\Components\TextInput::make('button_url')
                            ->label('Ссылка кнопки (URL)')
                            ->placeholder('#'),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromoSections::route('/'),
            'create' => Pages\CreatePromoSection::route('/create'),
            'edit' => Pages\EditPromoSection::route('/{record}/edit'),
        ];
    }
}
