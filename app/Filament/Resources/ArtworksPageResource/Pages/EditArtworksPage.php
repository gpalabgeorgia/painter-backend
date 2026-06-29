<?php

namespace App\Filament\Resources\ArtworksPageResource\Pages;

use App\Filament\Resources\ArtworksPageResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\ArtworksPage;

class EditArtworksPage extends EditRecord
{
    protected static string $resource = ArtworksPageResource::class;

    public function mount($record = null): void
    {
        // Ищем запись или создаем дефолтную, если в базе пусто
        $page = ArtworksPage::firstOrCreate(
            ['id' => 1],
            [
                's1_title' => 'Artworks',
                's1_subtitle' => 'Conversation',
                's1_text' => 'At sit molestie massa sed lorem nulla tempus ipsum suspendisse maecenas.'
            ]
        );

        parent::mount($page->id);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
