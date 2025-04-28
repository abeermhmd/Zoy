<?php

namespace App\Actions\Banners;

use App\Models\Banner;

class GetBannerAction
{
    public static function execute(string $id): Banner
    {
        return Banner::query()->where('id', $id)->first();
    }
}
