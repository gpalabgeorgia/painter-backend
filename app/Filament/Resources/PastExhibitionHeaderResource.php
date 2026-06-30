<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PastExhibitionHeaderResource\Pages;
use App\Models\PastExhibitionHeader;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PastExhibitionHeaderResource extends Resource
{
    // Теперь модель смотрит в СВОЮ собственную таблицу past_exhibition_headers
    protected static ?string $model = PastExhibitionHeader::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments';
    protected static ?string $navigationGroup = 'ВЫСТАВКИ';

    protected static ?string $navigationLabel = '4. Заголовки прошедших';
    protected static ?string $pluralModelLabel = 'Заголовки секции';
    protected static ?string $modelLabel = 'настройки заголовков';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('section_title')
                            ->label('Заголовок всей секции (слева)')
                            ->required(),

                        Forms\Components\Textarea::make('section_description')
                            ->label('Короткий текст всей секции (справа)')
                            ->rows(3)
                            ->required(),
                    ]),
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Здесь кнопка удаления безопасна — удалит только текст, фотки в другой таблице!
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManagePastExhibitionHeaders::route('/'),
        ];
    }
}
