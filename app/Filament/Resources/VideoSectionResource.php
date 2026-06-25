<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoSectionResource\Pages;
use App\Models\VideoSection;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class VideoSectionResource extends Resource
{
    protected static ?string $model = VideoSection::class;
    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationLabel = 'Главная: Видео';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([

                    // Тумблер активности с бизнес-валидацией
                    Forms\Components\Toggle::make('is_active')
                        ->label('Видео активно и отображается на сайте')
                        ->default(true)
                        ->rules([
                            function (\Closure $get, $record) {
                                return function (string $attribute, $value, \Closure $fail) use ($record) {
                                    if ($value) {
                                        // Ищем ДРУГИЕ активные записи, исключая текущую по ID при редактировании
                                        $activeCount = VideoSection::where('is_active', true)
                                            ->when($record, fn ($query) => $query->where('id', '!=', $record->id))
                                            ->count();

                                        if ($activeCount >= 1) {
                                            $fail('Удалите или отключите active видео для добавления нового');
                                        }
                                    }
                                };
                            },
                        ]),

                    // Название видео (например, Awards)
                    Forms\Components\TextInput::make('title')
                        ->label('Название видео / Подпись снизу')
                        ->placeholder('Например: Awards')
                        ->maxLength(255),

                    // Поле загрузки видео (MP4)
                    Forms\Components\FileUpload::make('video_url')
                        ->label('Загрузить видео файл (.mp4)')
                        ->disk('root')
                        ->directory('public/video')
                        ->required(fn ($record) => $record === null) // Обязательно только при создании нового
                        ->dehydrated(fn ($state) => filled($state))   // Не затирает старый файл в БД при пустом вводе
                        ->nullable(),

                    // Поле загрузки обложки (Превью)
                    Forms\Components\FileUpload::make('video_cover')
                        ->label('Обложка (Превью) видео')
                        ->image()
                        ->disk('root')
                        ->directory('public/img/video')
                        ->dehydrated(fn ($state) => filled($state))   // Не затирает старую картинку при пустом вводе
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Активно'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->limit(30),
                Tables\Columns\TextColumn::make('video_url')
                    ->label('Путь к видео')
                    ->limit(50),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideoSections::route('/'),
            'create' => Pages\CreateVideoSection::route('/create'),
            'edit' => Pages\EditVideoSection::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return VideoSection::where('is_active', true)->count() < 1;
    }
}
