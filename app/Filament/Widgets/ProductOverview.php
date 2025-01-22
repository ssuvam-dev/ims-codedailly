<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total Product",Product::count()),
            Stat::make("Total Category",Category::count()),
            Stat::make("Total Invoices",Purchase::count())
                ->description("Purchase Invoices")
                ->descriptionColor("success")
                ->descriptionIcon("heroicon-m-arrow-trending-up"),
        ];
    }
}
