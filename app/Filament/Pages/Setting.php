<?php

namespace App\Filament\Pages;

use App\Models\Setting as ModelsSetting;
use App\Models\TenantSetting;
use Filament\Events\TenantSet;
use Filament\Facades\Filament;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class Setting extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.setting';

    public ?array $data =[];

    public function mount():void
    {
        $tenant = Filament::getTenant();

        // first lets get all the settings key from admin panel.
        $settings = ModelsSetting::all()
                    ->groupBy('group') 
                    ->map(function ($items) {
                        return $items->pluck('value', 'key');
                    })
                    ->toArray();

        $tenantSettings = TenantSetting::where('tenant_id', $tenant->id)->get()->keyBy('setting_id');

        $mergedSettings = [];
        // merge them.
        foreach ($settings as $group => $items) {
            foreach ($items as $key => $value) {
                $setting = ModelsSetting::where('key', $key)->first();

                $tenantSetting = $tenantSettings->get($setting->id);

                if ($tenantSetting) {
                    $mergedSettings[$group][$key] = $tenantSetting->value;
                } else {
                    $mergedSettings[$group][$key] = $value;
                }
            }
        }

        $this->form->fill($mergedSettings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs($this->generateDynamicTabs())
            ])
            ->statePath('data');
    }

    public function generateDynamicTabs()
    {
        $settings = ModelsSetting::all()->groupBy('group');
        
        return $settings->map(function (Collection $moduleSettings, string $module) {
            return Tab::make($module)
                    ->label(str($module)->title()->replace('_', ' '))
                    ->schema(
                        $moduleSettings->map(function ($setting) {
                            return $this->generateField($setting);
                        })->toArray()
                    );
        })->toArray();
    }

    public function generateField($setting)
    {
        $label = str($setting->key)->title()->replace("_"," ");
        $name = "{$setting->group}.{$setting->key}";
        return match ($setting->type) {
            'text' => TextInput::make($name)
                        ->label($label),

            'boolean' => Toggle::make($name)
                        ->label($label),

            'select' =>Select::make($name)
                        ->label($label)
                        ->options(function()use($setting){
                            return $setting->attributes['options'];
                        }),
            
            "file" =>FileUpload::make($name)
                        ->label($label),
                        
            default => TextInput::make($name)
                ->label($label)
        };
    }


    public function save(): void
    {
        $tenantId = Filament::getTenant()->id;
        foreach ($this->form->getState() as $group) {
            if (is_array($group)) {
                foreach ($group as $key => $value) {
                    $settings[$key] = $value;
                }
            }
        }
        foreach ($settings as $key => $value) {
            $setting = ModelsSetting::where('key',$key)->first();
            if($setting)
            {
                TenantSetting::updateOrCreate([
                    "setting_id" => $setting->id,
                    "tenant_id" => $tenantId
                ],[
                    "value"=>$value
                ]);
            }
            
        }

         Notification::make()
         ->title('Settings saved successfully')
         ->success()
        ->send();
    }
}
