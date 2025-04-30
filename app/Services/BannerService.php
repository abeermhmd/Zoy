<?php

namespace App\Services;

use App\Actions\Banners\{AdPopUpUpdateAction, GetBannerAction, GetBannersAction,
    BannerAdUpdateAction, CreateBannerAction, UpdateBannerAction};
use App\Contracts\BannerContract;
use App\DataTransferObjects\Banners\AdPopUpDataTransfer;
use App\DataTransferObjects\Banners\BannerAdDataTransfer;
use App\DataTransferObjects\Banners\BannerDataTransfer;
use App\Models\{Banner,Setting };
use App\Traits\ImageTrait;
use App\TypeLinkBanner;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BannerService implements BannerContract
{
    use ImageTrait;

    public function getBanners(?array $filters = null): LengthAwarePaginator|Collection
    {
        return GetBannersAction::execute($filters);
    }

    public function getBanner(string $id): Banner
    {
        return GetBannerAction::execute($id);
    }

    public function createBanner(BannerDataTransfer $data): void
    {
        CreateBannerAction::execute($data);
    }

    public function updateBanner(Banner $banner, BannerDataTransfer $data): void
    {
        UpdateBannerAction::execute($this , $banner, $data);
    }

    public function bannerAdUpdate(BannerAdDataTransfer $data): void
    {
        $settings = Setting::first();
        BannerAdUpdateAction::execute($this,$settings, $data);
    }

    public function adPopUpUpdate(AdPopUpDataTransfer $data): void
    {
        $settings = Setting::first();
       AdPopUpUpdateAction::execute($this,$settings, $data);
    }

    public function typeLink(BannerDataTransfer|AdPopUpDataTransfer|BannerAdDataTransfer $data)
    {
        $typeLinkField = $data instanceof AdPopUpDataTransfer ? 'type_link_pop' : 'type_link';
        if (!isset($data->$typeLinkField)) {
            return null;
        }

        $typeLink = TypeLinkBanner::tryFrom((int) $data->$typeLinkField);

        return match ($typeLink) {
            TypeLinkBanner::PRODUCT => $data->product_id,
            TypeLinkBanner::MAINCATEGORY => $data->category_id,
            TypeLinkBanner::SUBCATEGORY => $data->sub_category_id,
            default => null,
        };
    }
}
