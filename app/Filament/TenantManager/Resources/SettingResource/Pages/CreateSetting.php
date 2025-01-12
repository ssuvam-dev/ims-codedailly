<?php

namespace App\Filament\TenantManager\Resources\SettingResource\Pages;

use App\Filament\TenantManager\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;
}
