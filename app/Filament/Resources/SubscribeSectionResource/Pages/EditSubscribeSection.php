<?php

namespace App\Filament\Resources\SubscribeSectionResource\Pages;

use App\Filament\Resources\SubscribeSectionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubscribeSection extends EditRecord
{
    protected static string $resource = SubscribeSectionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
