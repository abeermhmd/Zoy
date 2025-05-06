<?php

namespace App\Actions\Categories;

use App\Models\Category;

class GetCategoryAction
{
    public static function execute(string $id): Category
    {
        return Category::query()->where('id', $id)->first();
    }
}
