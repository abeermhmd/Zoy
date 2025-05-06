<?php

namespace App\DataTransferObjects\Colors;
use App\Traits\FromRequest;
class ColorFilterDataTransfer
{
    use FromRequest;
    public function __construct(
        public ?string $name = null,
        public ?string $hex_code= null,
        public ?string $status= null,
        public string $orderBy = 'id',
        public string $direction = 'desc',
        public bool $isPaginate = true,
    ) {}
}
