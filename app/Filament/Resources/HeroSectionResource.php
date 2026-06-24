<?php

namespace App\App\Filament\Resources; // Сохраняем твое пространство имен

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Models\HeroSection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-template';
    protected static ?string $navigationLabel = 'Главная: Hero секция';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Глобальный переключатель активности секции
                Forms\Components\Card::make()->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Секция активна и отображается на сайте')
                        ->default(true),
                ]),

                Forms\Components\Grid::make(3)->schema([

                    // ЛЕВАЯ ЧАСТЬ
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Placeholder::make('left_label')->label('=== ЛЕВАЯ ЧАСТЬ ==='),
                        Forms\Components\TextInput::make('left_title')->label('Заголовок'),
                        Forms\Components\Textarea::make('left_text_1')->label('Текст (строка 1)')->rows(2),
                        Forms\Components\Textarea::make('left_text_2')->label('Текст (строка 2)')->rows(2),
                    ])->columnSpan(1),

                    // ЦЕНТРАЛЬНАЯ ЧАСТЬ
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Placeholder::make('center_label')->label('=== ЦЕНТР (КАРТИНА) ==='),
                        Forms\Components\FileUpload::make('center_image')
                            ->label('Изображение картины')
                            ->image()
                            ->disk('root') // Используем корневой диск проекта
                            ->directory('public/img/hero') // Сохраняем строго в public/img/hero/
                            ->required(),
                    ])->columnSpan(1),

                    // ПРАВАЯ ЧАСТЬ
                    Forms\Components\Card::make()->schema([
                        Forms\Components\Placeholder::make('right_label')->label('=== ПРАВАЯ ЧАСТЬ ==='),
                        Forms\Components\TextInput::make('right_small_text')->label('Маленький текст (под красной линией)'),
                    ])->columnSpan(1),

                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активна'),

                Tables\Columns\TextColumn::make('left_title')
                    ->label('Заголовок слева'),

                Tables\Columns\ImageColumn::make('center_image')
                    ->label('Картина')
                    ->disk('root'), // Указываем диск root, чтобы Filament видел превью в таблице
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }

    // Ограничиваем до 1 записи (Singleton)
    public static function canCreate(): bool
    {
        return HeroSection::count() < 1;
    }
}
