<?php

namespace App\Actions\Banners;

use App\DataTransferObjects\Banners\AdPopUpDataTransfer;
use App\Services\BannerService;
use Illuminate\Support\Facades\DB;

class AdPopUpUpdateAction
{
    public static function execute( $settings,AdPopUpDataTransfer $data)
    {
        DB::transaction(function () use (  $settings , $data) {
            $service = app(BannerService::class);
            if ($data->ad_popUp_image) {
                $settings->ad_popUp_image = $service->storeImage($data->ad_popUp_image, 'settings',
                    $settings->getRawOriginal('ad_popUp_image') ? $settings->getRawOriginal('ad_popUp_image') : null);
            }
            $settings->type_link_pop = $data->type_link_pop;
            $settings->linked_id_pop = $service->typeLink($data);
            $settings->save();
        });
    }
}
