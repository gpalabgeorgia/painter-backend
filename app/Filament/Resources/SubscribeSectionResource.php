<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscribeSectionResource\Pages;
use App\Filament\Resources\SubscribeSectionResource\RelationManagers;
use App\Models\SubscribeSection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubscribeSectionResource extends Resource
{
    protected static ?string $model = SubscribeSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = '9. Блок подписки (Текст)';
    protected static ?string $navigationGroup = 'Главная';
    protected static ?int $navigationSort = 9;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
                    Forms\Components\Textarea::make('subtitle')->label('Подзаголовок')->rows(3)->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table { return $table->columns([]); }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscribeSections::route('/'),
            'create' => Pages\CreateSubscribeSection::route('/create'),
            'edit' => Pages\EditSubscribeSection::route('/{record}/edit'),
        ];
    }
}
