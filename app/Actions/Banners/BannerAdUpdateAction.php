<?php

namespace App\Actions\Banners;

use App\Services\BannerService;
use Illuminate\Support\Facades\DB;

class BannerAdUpdateAction
{
    public static function execute(BannerService $service, $settings, $data)
    {
        DB::transaction(function () use ($service,  $settings , $data) {
            if ($data->hasFile('banner_ad_image')) {
                $settings->banner_ad_image = $service->storeImage($data['banner_ad_image'], 'settings',
                    $settings->getRawOriginal('banner_ad_image') ? $settings->getRawOriginal('banner_ad_image') : null);
            }
            $settings->type_link = $data['type_link'];
            $settings->linked_id = $service->typeLink($data);
            $settings->save();
        });
    }
}
