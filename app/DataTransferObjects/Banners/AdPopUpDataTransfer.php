<?php

namespace App\DataTransferObjects\Banners;
use App\TypeBanner;
use Illuminate\Http\UploadedFile;
class AdPopUpDataTransfer
{
    public function __construct(
        public readonly int $type_link_pop,
        public readonly ?UploadedFile $ad_popUp_image = null,
        public readonly ?int $product_id = null,
        public readonly ?int $category_id = null,
        public readonly ?int $sub_category_id = null
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            type_link_pop: $request->input('type_link'),
            ad_popUp_image: $request->hasFile('ad_popUp_image') ? $request->file('ad_popUp_image') : null,
            product_id: $request->input('product_id'),
            category_id: $request->input('category_id'),
            sub_category_id: $request->input('sub_category_id')
        );
    }
}
