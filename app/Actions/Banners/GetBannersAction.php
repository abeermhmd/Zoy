<?php

namespace App\Actions\Banners;

use App\Models\Banner;
use App\Services\Actions\DataTransferObjects\BannerFilterDataTransfer;

class GetBannersAction
{
    public static function execute($filters)
    {
        $query = Banner::filter($filters);

        return $filters['isPaginate']
            ? $query->paginate($filters['perPage']  )
            : $query->get();
    }
}
