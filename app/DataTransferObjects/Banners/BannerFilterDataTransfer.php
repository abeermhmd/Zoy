<?php

namespace App\DataTransferObjects\Banners;
use Illuminate\Http\UploadedFile;
class BannerFilterDataTransfer
{
    public function __construct(
        public readonly int  $type,
        public readonly int $type_link,
        public readonly ?UploadedFile $image = null,
        public readonly ?int $product_id = null,
        public readonly ?int $category_id = null,
        public readonly ?int $sub_category_id = null
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            type: $request->input('type'),
            type_link: $request->input('type_link'),
            image: $request->hasFile('image') ? $request->file('image') : ($request->hasFile('url') ? $request->file('url') : null),
            product_id: $request->input('product_id'),
            category_id: $request->input('category_id'),
            sub_category_id: $request->input('sub_category_id')
        );
    }
}
