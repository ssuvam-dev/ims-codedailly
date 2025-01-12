<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable =[
        'key',
        "value",
        "type",
        "attributes",
        "group"
    ];
    protected $casts =[
        "attributes" =>"array"
    ];

    public function settings()
    {
        return $this->hasMany(TenantSetting::class);
    }
}
