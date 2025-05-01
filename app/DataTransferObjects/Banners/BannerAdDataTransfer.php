<?php

namespace App\DataTransferObjects\Banners;
use App\Traits\FromRequest;
use Illuminate\Http\UploadedFile;
class BannerAdDataTransfer
{
    use FromRequest;
    public function __construct(
        public readonly int $type_link,
        public readonly ?UploadedFile $banner_ad_image = null,
        public readonly ?int $product_id = null,
        public readonly ?int $category_id = null,
        public readonly ?int $sub_category_id = null
    ) {}

}
