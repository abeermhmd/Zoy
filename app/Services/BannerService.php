<?php

namespace App\Services;

use App\Actions\Banners\{AdPopUpUpdateAction, GetBannerAction, GetBannersAction,
    BannerAdUpdateAction, CreateBannerAction, UpdateBannerAction};
use App\Contracts\BannerContract;
use App\Models\{Banner,Setting };
use App\Traits\ImageTrait;
use App\TypeLinkBanner;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BannerService implements BannerContract
{
    use ImageTrait;

    public function getBanners(array $filters): LengthAwarePaginator|Collection
    {
        return GetBannersAction::execute($filters);
    }

    public function getBanner(string $id): Banner
    {
        return GetBannerAction::execute($id);
    }

    public function createBanner(Banner $banner, $data): void
    {
        CreateBannerAction::execute($this, $banner, $data);
    }

    public function updateBanner(Banner $banner, $data): void
    {
        UpdateBannerAction::execute($this , $banner, $data);
    }

    public function bannerAdUpdate($data): void
    {
        $settings = Setting::first();
        BannerAdUpdateAction::execute($this,$settings, $data);
    }

    public function adPopUpUpdate($data): void
    {
        $settings = Setting::first();
       AdPopUpUpdateAction::execute($this,$settings, $data);
    }

    public function typeLink($data)
    {
        $typeLink = TypeLinkBanner::tryFrom((int) $data['type_link']);
        return match ($typeLink) {
            TypeLinkBanner::PRODUCT => $data['product_id'],
            TypeLinkBanner::MAINCATEGORY => $data['category_id'],
            TypeLinkBanner::SUBCATEGORY => $data['sub_category_id'],
            default => null,
        };
    }
}
