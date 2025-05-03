<?php

namespace App\Actions\SubCategories;

use App\Models\Category;

class GetSubCategoryAction
{
    public static function execute(string $id): Category
    {
        return Category::query()->where('parent_id' , '!=', null)->where('id', $id)->first();
    }
}
