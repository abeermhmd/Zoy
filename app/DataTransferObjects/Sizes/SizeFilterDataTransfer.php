<?php

namespace App\DataTransferObjects\Sizes;
use App\Traits\FromRequest;
class SizeFilterDataTransfer
{
    use FromRequest;
    public function __construct(
        public ?string $name = null,
        public ?string $status= null,
        public string $orderBy = 'id',
        public string $direction = 'desc',
        public bool $isPaginate = true,
    ) {}
}
