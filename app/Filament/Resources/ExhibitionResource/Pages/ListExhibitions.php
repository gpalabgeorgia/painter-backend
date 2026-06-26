<?php

namespace App\Filament\Resources\ExhibitionResource\Pages;

use App\Filament\Resources\ExhibitionResource;
use App\Models\ExhibitionHeader;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;

class ListExhibitions extends ListRecords
{
    protected static string $resource = ExhibitionResource::class;

    // Свойства для хранения состояния полей формы шапки
    public $main_title;
    public $subtitle;

    public function mount(): void
    {
        parent::mount();

        $header = ExhibitionHeader::first() ?? new ExhibitionHeader();

        $this->main_title = $header->main_title;
        $this->subtitle = $header->subtitle;
    }

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Выводим кастомный HTML-блок с формой прямо над основной таблицей Filament
    protected function getHeader(): \Illuminate\Contracts\View\View|null
    {
        return view('filament.resources.exhibitions.header-form', [
            'main_title' => $this->main_title,
            'subtitle' => $this->subtitle,
        ]);
    }
}
