<?php

namespace App\DataTransferObjects\Sizes;
use App\Traits\FromRequest;

class SizeDataTransfer
{
    use FromRequest;

    public function __construct(
        public readonly ?string $name_en = null,
        public readonly ?string $name_ar = null,
    ) {}
}
