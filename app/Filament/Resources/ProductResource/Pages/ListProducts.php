<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Exports\ProductExporter;
use App\Filament\Imports\ProductImporter;
use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\ImportAction;
use Filament\Facades\Filament;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(ProductExporter::class)
                ->formats([
                    ExportFormat::Csv,
                ]),
            ImportAction::make()
                ->importer(ProductImporter::class)
                ->options([
                    "tenant_id"=>Filament::getTenant()->id
                ])
            
        ];
    }

    public function getTabs() :array{
        return [
            "all" => Tab::make(),
            "out_of_safety_stock" => Tab::make()
                                        ->modifyQueryUsing(function(Builder $query){
                                            return $query->whereColumn('quantity','<=','safety_stock');
                                        }),
        ];
    }
}
