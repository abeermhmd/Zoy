<?php

namespace App\DataTransferObjects\Admin;

use App\Traits\FromRequest;

class AdminDataTransfer
{
    use FromRequest;
        public function __construct(
           public readonly ?int $id = null,
           public readonly ?string $name = null,
           public readonly ?string $mobile = null,
           public readonly ?string $email = null,
           public readonly ?string $password = null,
           public readonly ?array $permissions= null,

        )
        {
        }
}
