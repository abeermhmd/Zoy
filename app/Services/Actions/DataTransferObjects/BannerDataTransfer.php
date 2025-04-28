<?php

namespace App\Services\Actions\DataTransferObjects;

class BannerDataTransfer
{
    public function __construct(
        protected $id,
        protected $title,
        protected $image,
        protected $link,
        protected $status,
        protected $order,
        protected $created_at,
        protected $updated_at,
    ){}
}
