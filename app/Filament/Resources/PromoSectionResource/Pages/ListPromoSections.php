<?php

namespace App\Filament\Resources\PromoSectionResource\Pages;

use App\Filament\Resources\PromoSectionResource;
use App\Models\PromoSection;
use Filament\Resources\Pages\ListRecords;

class ListPromoSections extends ListRecords
{
    protected static string $resource = PromoSectionResource::class;

    public function mount(): void
    {
        parent::mount();

        $record = PromoSection::first() ?? PromoSection::create([
            'title' => 'Learn Painting',
            'description' => 'Diam praesent ullamcorper cursus integer ullamcorper ac lorem scelerisque faucibus dignissim eget sapien.',
            'button_text' => 'START NOW',
            'button_url' => '#',
        ]);

        $routeName = PromoSectionResource::getRouteBaseName() . '.edit';

        redirect()->route($routeName, ['record' => $record->id]);
    }
}
