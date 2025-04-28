<?php

namespace App\Services;
use App\Models\City;
use App\Models\Country;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class ShippingService
{

    public function updateContent(Setting $setting, $data): void
    {
        DB::transaction(function () use ($setting, $data) {
            $translatedFields = ['shipping_content_kuwait','shipping_content_outside_kuwait'];
            storeTranslatedFields($setting, $translatedFields, $data);
            $setting->save();
        });
    }
   public function updateShippingPrices($data): void
   {
        DB::transaction(function () use ($data) {
            if (isset($data['countries']) && is_array($data['countries'])) {
                foreach ($data['countries'] as $countryData) {
                    Country::where('id', $countryData['id'])->update([
                    'delivery_fees' => $countryData['delivery_fees'],
                ]);
                }
            }

            if (isset($data['cities']) && is_array($data['cities'])) {
                foreach ($data['cities'] as $cityData) {
                    City::where('id', $cityData['id'])->update([
                        'delivery_fees' => $cityData['delivery_fees'],
                    ]);
                }
            }
        });
   }



}
