<?php

namespace App\Filament\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as PagesDashboard;
use Filament\Pages\Page;

class Dashboard extends PagesDashboard
{
    public function getActions():array
    {
        return [
            Action::make("create_purchase")
                ->button()
                ->outlined()
                ->url(PurchaseResource::getUrl('create'))
        ];
    }
}
