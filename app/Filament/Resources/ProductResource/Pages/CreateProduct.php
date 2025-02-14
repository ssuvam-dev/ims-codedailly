<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Category;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $tenantId = Filament::getTenant()->id;
        if($data['category_name'])
        {
            $category = Category::create([
                "name" => $data['category_name'],
                'tenant_id' =>$tenantId
            ]);

            $data['category_id'] = $category->id;
            $data['tenant_id'] = $tenantId;
            unset($data['category_name']);
        }
        return static::getModel()::create($data);
    }
}
