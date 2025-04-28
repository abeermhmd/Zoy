<?php

namespace App\Actions\Banners;

use App\Services\BannerService;
use Illuminate\Support\Facades\DB;

class AdPopUpUpdateAction
{
    public static function execute(BannerService $service, $settings, $data)
    {
        DB::transaction(function () use ($service,  $settings , $data) {
            if ($data->hasFile('ad_popUp_image')) {
                $settings->ad_popUp_image = $service->storeImage($data['ad_popUp_image'], 'settings',
                    $settings->getRawOriginal('ad_popUp_image') ? $settings->getRawOriginal('ad_popUp_image') : null);
            }
            $settings->type_link_pop = $data['type_link'];
            $settings->linked_id_pop = $service->typeLink($data);
            $settings->save();
        });
    }
}
