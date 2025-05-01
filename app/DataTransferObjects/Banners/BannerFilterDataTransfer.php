<?php

namespace App\DataTransferObjects\Banners;
use App\Traits\FromRequest;
class BannerFilterDataTransfer
{
    use FromRequest;
    public function __construct(
        public ?int $type = null,
        public ?int $type_link = null,
        public ?string $status = null,
        public bool $isPaginate = true,
    ) {}
}
