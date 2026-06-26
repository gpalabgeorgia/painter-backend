<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialSectionResource\Pages;
use App\Models\TestimonialSection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;

class TestimonialSectionResource extends Resource
{
    protected static ?string $model = TestimonialSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-alt-2';
    protected static ?string $navigationLabel = 'Секция: Цитата';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Textarea::make('quote')
                        ->label('Текст цитаты')
                        ->required()
                        ->rows(4),

                    Forms\Components\TextInput::make('author_name')
                        ->label('Имя автора')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('author_title')
                        ->label('Должность / Подпись автора')
                        ->required()
                        ->maxLength(255),
                ]),
            ]);
    }

    // Отключаем таблицу, так как мы сразу будем перенаправлять на редактирование
    public static function table(Table $table): Table
    {
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonialSections::route('/'),
            'create' => Pages\CreateTestimonialSection::route('/create'),
            'edit' => Pages\EditTestimonialSection::route('/{record}/edit'),
        ];
    }
}
