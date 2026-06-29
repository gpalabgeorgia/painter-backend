<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtworkHeaderResource\Pages;
use App\Models\ArtworkHeader;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

class ArtworkHeaderResource extends Resource
{
    protected static ?string $model = ArtworkHeader::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = '7. Заголовок витрины картин';
    protected static ?string $navigationGroup = 'Главная';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Заголовок секции')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('subtitle')
                        ->label('Подзаголовок / Описание')
                        ->rows(3)
                        ->required(),
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
            'index' => Pages\ListArtworkHeaders::route('/'),
            'create' => Pages\CreateArtworkHeader::route('/create'),
            'edit' => Pages\EditArtworkHeader::route('/{record}/edit'),
        ];
    }
}
