<?php

namespace App\Contracts;

use App\Models\Banner;
use App\Services\BannerService;

interface BannerContract
{
    public function getBanners(array $filters);
    public function getBanner(string $id);
    public function createBanner(Banner $banner , $data);
    public function updateBanner(Banner $banner, $data);
    public function bannerAdUpdate($data);
    public function adPopUpUpdate($data);
}
