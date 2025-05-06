<?php

namespace App\DataTransferObjects\Products;
use App\Traits\FromRequest;
use Illuminate\Http\UploadedFile;

class ProductDataTransfer
{
    use FromRequest;

    public function __construct(
        public readonly ?float $discount = null,
        public readonly ?UploadedFile $image = null,
        public readonly ?string $department = null,
        public readonly ?string $name_en = null,
        public readonly ?string $name_ar = null,
        public readonly ?string $key_words_en = null,
        public readonly ?string $key_words_ar = null,
        public readonly ?int $id = null,
        public readonly ?string $is_featured = null,

    ) {}
}
