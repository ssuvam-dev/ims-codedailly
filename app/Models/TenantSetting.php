<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantSetting extends Model
{
    protected $guarded =[];
    protected $casts =[
        "data"=>"array"
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
