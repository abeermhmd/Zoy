<?php

namespace App\Actions\Banners;

use App\Services\BannerService;
use Illuminate\Support\Facades\DB;

class CreateBannerAction
{
    public static function execute(BannerService $service, $banner, $data)
    {
        DB::transaction(function () use ($service, $banner, $data) {
            if ($data->type == 1 && $data->hasFile('image')) {
                $banner->image = $service->storeImage($data->file('image'), 'mainImages');
            } elseif($data->type == 2 && $data->hasFile('url')) {
                $banner->image = $service->storeImage($data->file('url'), 'mainImages', null, null, null, 2);
            }
            $banner->type = $data['type'];
            $banner->type_link = $data['type_link'];
            $banner->linked_id = $service->typeLink($data);
            $banner->save();
        });
    }
}
