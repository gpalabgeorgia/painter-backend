<?php

namespace App\Filament\Resources\ArtworkHeaderResource\Pages;

use App\Filament\Resources\ArtworkHeaderResource;
use App\Models\ArtworkHeader;
use Filament\Resources\Pages\ListRecords;

class ListArtworkHeaders extends ListRecords
{
    protected static string $resource = ArtworkHeaderResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = ArtworkHeader::first() ?? ArtworkHeader::create([
            'title' => 'Latest artwork',
            'subtitle' => 'Tempor ac tincidunt feugiat dignissim quis sed donec cursus ornare varius sed sagittis nibh.',
        ]);

        $routeName = ArtworkHeaderResource::getRouteBaseName() . '.edit';

        $this->redirect(route($routeName, ['record' => $record->id]));
    }
}
