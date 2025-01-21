<?php

use App\Models\Setting;

if(!function_exists("getSettings"))
{
    /**
     * @param array of columns
     * @param String tenantId
     * @return array of settings
     */

    function getSettings(array $columns, $tenantId)
    {
        $finalResult = [];
        $settings = Setting::whereIn('key', $columns)
            ->with(['settings' => function($query) use ($tenantId) {
                $query->where('tenant_id', $tenantId);
            }])
            ->get();
        foreach ($columns as $key => $column) {
            $setting = $settings->firstWhere('key', $column);
            if($setting)
            {
                $tenantSettings  = $setting->settings->first();
                if($tenantSettings)
                {
                    $finalResult[$column]=$tenantSettings->value 
                                                ? $tenantSettings->value
                                                :$setting->value ;
                }
                else
                {
                    $finalResult[$column] = "";
                }

            }
        }
        return $finalResult;
    }
}