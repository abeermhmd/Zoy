<?php

namespace App\DataTransferObjects\SubCategories;
use App\Traits\FromRequest;
class SubCategoryFilterDataTransfer
{
    use FromRequest;
    public function __construct(
        public ?int $id = null,
        public ?string $name = null,
        public ?string $parent_id = null,
        public ?string $is_featured= null,
        public ?string $status= null,
        public string $orderBy = 'id',
        public string $direction = 'desc',
        public bool $isPaginate = true,
    ) {}
}
