<?php

namespace App\Models;

use Filament\Events\TenantSet;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{

    protected $fillable  =[
        "name",
        'email',
        "contact",
        "data"
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
    
    public function providers()
    {
        return $this->hasMany(Provider::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function units()
    {
        return $this->hasMany(Unit::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function settings()
    {
        return $this->hasMany(TenantSetting::class);
    }
}
