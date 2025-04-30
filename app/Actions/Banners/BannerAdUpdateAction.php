<?php

namespace App\Actions\Banners;

use App\DataTransferObjects\Banners\BannerAdDataTransfer;
use App\Services\BannerService;
use Illuminate\Support\Facades\DB;

class BannerAdUpdateAction
{
    public static function execute($settings,BannerAdDataTransfer $data)
    {
        DB::transaction(function () use ($settings , $data) {
            $service = app(BannerService::class);
            if ($data->banner_ad_image) {
                $settings->banner_ad_image = $service->storeImage($data->banner_ad_image, 'settings',
                    $settings->getRawOriginal('banner_ad_image') ? $settings->getRawOriginal('banner_ad_image') : null);
            }
            $settings->type_link = $data->type_link;
            $settings->linked_id = $service->typeLink($data);
            $settings->save();
        });
    }
}
