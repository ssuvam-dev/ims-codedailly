<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceRecord extends Model
{
    protected $fillable =[
        "user_id",
        "purchase_id",
        "data"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchase_id()
    {
        return $this->belongsTo(Purchase::class);
    }
}
