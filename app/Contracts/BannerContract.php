<?php

namespace App\Contracts;

use App\DataTransferObjects\Banners\{AdPopUpDataTransfer,
    BannerAdDataTransfer,
    BannerDataTransfer,
    BannerFilterDataTransfer};
use App\Models\Banner;

interface BannerContract
{
    public function getBanners(?BannerFilterDataTransfer $filters = null);

    public function getBanner(string $id);

    public function createBanner(BannerDataTransfer $data);

    public function updateBanner(Banner $banner, BannerDataTransfer $data);

    public function bannerAdUpdate(BannerAdDataTransfer $data);

    public function adPopUpUpdate(AdPopUpDataTransfer $data);
}
