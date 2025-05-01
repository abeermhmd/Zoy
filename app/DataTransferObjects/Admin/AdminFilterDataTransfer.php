<?php

namespace App\DataTransferObjects\Admin;

use App\Traits\FromRequest;

class AdminFilterDataTransfer
{
    use FromRequest;
        public function __construct(
            public bool $isPaginate = true,
            public string $orderBy = 'id',
            public string $direction = 'desc',
            public ?string $name = null,
           public ?string $mobile = null,
           public ?string $email = null,
        )
        {
        }
}
