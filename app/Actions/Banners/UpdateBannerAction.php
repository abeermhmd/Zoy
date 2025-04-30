<?php

namespace App\Actions\Banners;

use App\DataTransferObjects\Banners\BannerDataTransfer;
use App\Services\BannerService;
use App\TypeBanner;
use Illuminate\Support\Facades\DB;

class UpdateBannerAction
{
    public static function execute( $banner, BannerDataTransfer $data)
    {
        DB::transaction(function () use( $banner, $data) {
            $service = app(BannerService::class);
            if (in_array($data->type, [TypeBanner::IMAGE->value, TypeBanner::VIDEO->value]) && $data->image) {
                $typeImage = ($data->type === TypeBanner::VIDEO->value) ? TypeBanner::VIDEO->value : TypeBanner::IMAGE->value;
                $banner->image = $service->storeImage($data->image, 'mainImages', null, null, null, $typeImage);
            }
            $banner->type = $data->type;
            $banner->type_link = $data->type_link;
            $banner->linked_id = $service->typeLink($data);
            $banner->save();
        });
    }
}
