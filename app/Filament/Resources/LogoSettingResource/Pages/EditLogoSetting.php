<?php

namespace App\Filament\Resources\LogoSettingResource\Pages;

use App\Filament\Resources\LogoSettingResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogoSetting extends EditRecord
{
    protected static string $resource = LogoSettingResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
