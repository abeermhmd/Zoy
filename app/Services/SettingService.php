<?php

namespace App\Services;
use App\Models\Setting;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    use ImageTrait;

    public function updateSetting(Setting $setting, $data): void
    {
        DB::transaction(function () use ($setting, $data) {
            $translatedFields = [
                'title' ,'instagram_text_footer'
            ];
            storeTranslatedFields($setting, $translatedFields, $data);

            $setting->info_email = trim($data->input('info_email', $setting->info_email));
            $setting->mobile = trim($data->input('mobile', $setting->mobile));
            $setting->whatsApp = trim($data->input('whatsApp', $setting->whatsApp));
            $setting->dashboard_paginate = $data->input('dashboard_paginate', $setting->dashboard_paginate);
            $setting->website_paginate = $data->input('website_paginate', $setting->website_paginate);
            $setting->remember_continue_order = $data->input('remember_continue_order', $setting->remember_continue_order);
            $setting->remember_continue_order = $data->input('remember_continue_order', $setting->remember_continue_order);
            $setting->remember_abandoned_cart = $data->input('remember_abandoned_cart', $setting->remember_abandoned_cart);
            $setting->instagram = trim($data->input('instagram', $setting->instagram));
            $setting->area = trim($data->input('area', $setting->area));
            $setting->block = trim($data->input('block', $setting->block));
            $setting->street = trim($data->input('street', $setting->street));
            $setting->address = trim($data->input('address', $setting->address));
            $setting->map_location_pinpoint = trim($data->input('map_location_pinpoint', $setting->map_location_pinpoint));
            $setting->BHD = $data->BHD;
            $setting->OMR = $data->OMR;
            $setting->QAR = $data->QAR;
            $setting->SAR = $data->SAR;
            $setting->AED = $data->AED;

            $images = [
                'logo' => 'logo',
                'image' => 'image',
            ];

            foreach ($images as $inputName => $fieldName) {
                if ($data->hasFile($inputName)) {
                    $setting->$fieldName = $this->storeImage($data->$inputName, 'settings', $setting->getRawOriginal($fieldName));
                }
            }
            $setting->save();

            Cache::forget('currency');
            Cache::forever('currency', $setting);
        });
    }
    public function updateSystemMaintenance(Setting $setting, $data): void
    {
        $setting->is_maintenance_mode = ($data->get('is_maintenance_mode') === 'on') ? 1 : 0;
        $setting->is_alowed_register = ($data->get('is_alowed_register') === 'on') ? 1 : 0;
        $setting->is_alowed_login = ($data->get('is_alowed_login') === 'on') ? 1 : 0;
        $setting->is_alowed_subscription = ($data->get('is_alowed_subscription') === 'on') ? 1 : 0;
        $setting->is_alowed_order = ($data->get('is_alowed_order') === 'on') ? 1 : 0;

        $setting->save();
    }
    public function updateSystemSeo(Setting $setting, $data)
    {
        $setting->seo_in_header = trim($data->input('seo_in_header', $setting->seo_in_header));
        $setting->seo_in_body = trim($data->input('seo_in_body', $setting->seo_in_body));
        storeTranslatedFields($setting, ['key_words'], $data);
        $setting->save();
    }


}
