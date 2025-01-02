<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use App\Models\Purchase;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;

    public function handleRecordCreation(array $data) : Model
    {
        $purchase  = Purchase::create([
            "tenant_id" => Filament::getTenant()->id,
            "provider_id" => $data['provider_id'],
            "invoice_no" => $data['invoice_no'],
            "purchase_date" => $data['purchase_date'],
            "total" => $data['total_amount'],
            "discount" =>  $data['discount']
        ]);

        $products= $data["product"];
        foreach($products as $product)
        {
            $purchase->products()->create([
                "product_id"=>$product['product_id'],
                "price"=>$product['price'],
                "quantity" => $product['quantity']
           ]);
        }
        return $purchase;
    }
}
