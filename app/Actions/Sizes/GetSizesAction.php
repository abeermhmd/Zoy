<?php

namespace App\Actions\Sizes;

use App\DataTransferObjects\Sizes\SizeFilterDataTransfer;
use App\Models\Size;

class GetSizesAction
{
    public static function execute(?SizeFilterDataTransfer $filters)
    {
        $query = Size::filter($filters)
        ->orderBy($filters->orderBy, $filters->direction);
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
  }
}
