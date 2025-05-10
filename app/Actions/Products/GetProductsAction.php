<?php

namespace App\Actions\Products;

use App\DataTransferObjects\Products\ProductFilterDataTransfer;
use App\Models\Product;

class GetProductsAction
{
    public static function execute(?ProductFilterDataTransfer $filters)
    {
        $query = Product::filter($filters)->when($filters && $filters->idNotEqual, fn($query) => $query->where('id', '!=', $filters->idNotEqual))
        ->orderBy($filters->orderBy, $filters->direction);
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
  }
}
