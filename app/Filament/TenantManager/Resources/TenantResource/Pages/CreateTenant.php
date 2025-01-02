<?php

namespace App\Filament\TenantManager\Resources\TenantResource\Pages;

use App\Filament\TenantManager\Resources\TenantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;
}
