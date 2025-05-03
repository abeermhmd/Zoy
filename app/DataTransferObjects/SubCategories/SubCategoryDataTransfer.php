<?php

namespace App\DataTransferObjects\SubCategories;
use App\Traits\FromRequest;
use Illuminate\Http\UploadedFile;

class SubCategoryDataTransfer
{
    use FromRequest;

    public function __construct(
        public readonly ?UploadedFile $image = null,
        public readonly ?int $parent_id = null,
        public readonly ?string $name_en = null,
        public readonly ?string $name_ar = null,
        public readonly ?string $key_words_en = null,
        public readonly ?string $key_words_ar = null,
        public readonly ?int $id = null,
        public readonly ?string $is_featured = null,

    ) {}
}
