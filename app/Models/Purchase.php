<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded =[];

    protected $casts =[
        "data"=>"json"
    ];
    
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // purchase belongs to providers..
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    // purhcase have many products...
    public function products()
    {
        return $this->hasMany(PurchaseProduct::class);
    }

    // printing records relationship.
    public function invoiceRecords()
    {
        return $this->hasMany(InvoiceRecord::class);
    }
}
