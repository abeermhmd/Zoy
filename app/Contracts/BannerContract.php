<?php

namespace App\Contracts;

use App\DataTransferObjects\Banners\AdPopUpDataTransfer;
use App\DataTransferObjects\Banners\BannerAdDataTransfer;
use App\DataTransferObjects\Banners\BannerDataTransfer;
use App\Models\Banner;

interface BannerContract
{
    public function getBanners(?array $filters = null);
    public function getBanner(string $id);
    public function createBanner(BannerDataTransfer $data);
    public function updateBanner(Banner $banner, BannerDataTransfer $data);
    public function bannerAdUpdate(BannerAdDataTransfer $data);
    public function adPopUpUpdate(AdPopUpDataTransfer $data);
}
