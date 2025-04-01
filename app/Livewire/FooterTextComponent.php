<?php

namespace App\Livewire;

use App\Filament\Pages\Setting;
use App\Models\Setting as ModelsSetting;
use App\Models\Tenant;
use App\Models\TenantSetting;
use Filament\Facades\Filament;
use Livewire\Component;

class FooterTextComponent extends Component
{
    public $footerText;

    public function mount()
    {
        $settings = ModelsSetting::where('key',"Add Footer Text")->first();
        $this->footerText =  TenantSetting::where('tenant_id',Filament::getTenant()?->id)
                            ->where('setting_id',$settings->id)
                            ->first()?->value ?? "Edit Footer Text from Settings";
    }
    public function render()
    {
        return view('livewire.footer-text-component');
    }
}
