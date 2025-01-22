<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class SafetyStock extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->striped()
            ->heading("Out of Safety Stock")
            ->query(
                Product::whereColumn("quantity","<=",'safety_stock')
            )
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('quantity'),
                TextColumn::make("safety_stock")
            ])
            ->actions([
                Action::make("edit")
                    ->url(function($record){
                        return ProductResource::getUrl('edit',['record'=>$record->id]);
                    })
            ]);
    }
}
