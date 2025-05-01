<?php

namespace App\Actions\Banners;

use App\DataTransferObjects\Banners\BannerFilterDataTransfer;
use App\Models\Banner;

class GetBannersAction
{
    public static function execute(BannerFilterDataTransfer $filters)
    {
        $query = Banner::filter($filters);
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
    }

}
