<?php

namespace App\Actions\Banners;

use App\Models\Banner;
use App\Services\Actions\DataTransferObjects\BannerFilterDataTransfer;

class GetBannersAction
{
    public static function execute($filters)
    {
        $filters = $filters ?? [];
        $query = Banner::filter($filters);

        if ($filters['isPaginate'] ?? false) {
            $perPage = get_setting('dashboard_paginate');
            $banners = $query->paginate($perPage);
            return $banners->appends(request()->query());
        } else {
            return $query->get();
        }
    }
}
