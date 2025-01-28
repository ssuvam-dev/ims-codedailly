<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
            ->requiredMapping()
            ->rules(['required', 'max:255']),

            ImportColumn::make('code')
                ->label('Code')
                ->requiredMapping(),

            ImportColumn::make('quantity')
                ->label('Quantity')
                ->requiredMapping(),

            ImportColumn::make('price')
                ->numeric()
                ->rules(['numeric', 'min:0']),

            ImportColumn::make('category')
                ->relationship(resolveUsing:'name')
        
            // ImportColumn::make('safety_stock')
            //     ->label('Safety Stock')
            //     ->requiredMapping(),
        ];
    }

    public function resolveRecord(): ?Product
    {
        $tenantId = $this->options['tenant_id'];
        \Log::info($this->data);
        return Product::firstOrNew([
            "code"=>$this->data['code'],
            'tenant_id' =>$tenantId
        ],[
            "name" =>$this->data['name'],
            "quantity" => $this->data['quantity'],
            "price" =>$this->data['price'],
            'category_id' =>$this->data['category'],
            "unit_id" =>1 // for testing..

        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
