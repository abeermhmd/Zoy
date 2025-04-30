<?php

namespace App\Actions\Banners;

use App\DataTransferObjects\Banners\BannerDataTransfer;
use App\Models\Banner;
use App\Services\BannerService;
use App\TypeBanner;
use Illuminate\Support\Facades\DB;

class CreateBannerAction
{

    public static function execute(BannerDataTransfer $data)
    {
        DB::transaction(function () use ($data) {
            $bannerService = app(BannerService::class);
            $banner = new Banner();
            if (in_array($data->type, [TypeBanner::IMAGE->value, TypeBanner::VIDEO->value]) && $data->image) {
                $typeImage = ($data->type === TypeBanner::VIDEO->value) ? TypeBanner::VIDEO->value : TypeBanner::IMAGE->value;
                $banner->image = $bannerService->storeImage($data->image, 'mainImages', null, null, null, $typeImage);
            }
            $banner->type = $data->type;
            $banner->type_link = $data->type_link;
            $banner->linked_id = $bannerService->typeLink($data);
            $banner->save();
        });
    }
}
