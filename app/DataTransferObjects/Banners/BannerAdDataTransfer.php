<?php

namespace App\DataTransferObjects\Banners;
use Illuminate\Http\UploadedFile;
class BannerAdDataTransfer
{
    public function __construct(
        public readonly int $type_link,
        public readonly ?UploadedFile $banner_ad_image = null,
        public readonly ?int $product_id = null,
        public readonly ?int $category_id = null,
        public readonly ?int $sub_category_id = null
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            type_link: $request->input('type_link'),
            banner_ad_image: $request->hasFile('banner_ad_image') ? $request->file('banner_ad_image') : null,
            product_id: $request->input('product_id'),
            category_id: $request->input('category_id'),
            sub_category_id: $request->input('sub_category_id')
        );
    }
}
