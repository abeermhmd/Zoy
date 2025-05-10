<?php

namespace App\Actions\Products;

use App\Models\Product;

class GetProductAction
{
    public static function execute(string $id, array $with = [], bool $hasVariants = false): Product
    {
        $query = Product::query()
            ->with($with)
            ->where('id', $id);

        if ($hasVariants) {
            $query->where('has_variants', 1);
        }
        return $query->firstOrFail();
    }
}
