<?php

namespace App\Actions\SubCategories;

use App\DataTransferObjects\SubCategories\SubCategoryFilterDataTransfer;
use App\Models\Category;

class GetSubCategoriesAction
{
    public static function execute(?SubCategoryFilterDataTransfer $filters)
    {
        $query = Category::where('parent_id' , '!=', null)->filter($filters)
        ->orderBy($filters->orderBy, $filters->direction);
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
  }
}
