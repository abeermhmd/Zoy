<?php

namespace App\DataTransferObjects\Categories;
use App\Traits\FromRequest;
class CategoryFilterDataTransfer
{
    use FromRequest;
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $department = null,
        public ?string $is_featured= null,
        public ?string $status= null,
        public string $orderBy = 'id',
        public string $direction = 'desc',
        public bool $isPaginate = true,
    ) {}
}
