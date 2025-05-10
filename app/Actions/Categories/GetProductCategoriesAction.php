<?php

namespace App\Actions\Categories;

use App\Models\Category;

class GetProductCategoriesAction
{
    public static function execute()
    {
        return Category::active()->where(function ($query) {
            $query->whereNull('parent_id')->whereDoesntHave('subcategories')
                ->orWhereNotNull('parent_id');
        })->orderBy('id')->get();
    }
}
