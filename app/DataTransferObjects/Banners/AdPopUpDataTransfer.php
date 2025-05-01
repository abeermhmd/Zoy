<?php

namespace App\DataTransferObjects\Banners;
use App\Traits\FromRequest;
use Illuminate\Http\UploadedFile;
class AdPopUpDataTransfer
{
    use FromRequest;
    public function __construct(
        public readonly int $type_link_pop,
        public readonly ?UploadedFile $ad_popUp_image = null,
        public readonly ?int $product_id = null,
        public readonly ?int $category_id = null,
        public readonly ?int $sub_category_id = null
    ) {}


}
