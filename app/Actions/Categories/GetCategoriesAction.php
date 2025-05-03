<?php

namespace App\Actions\Categories;

use App\DataTransferObjects\Admins\AdminFilterDataTransfer;
use App\DataTransferObjects\Categories\CategoryFilterDataTransfer;
use App\Models\Admin;
use App\Models\Category;

class GetCategoriesAction
{
    public static function execute(?CategoryFilterDataTransfer $filters)
    {
        $query = Category::where('parent_id' , null)->filter($filters)
        ->orderBy($filters->orderBy, $filters->direction);
        if ($filters->isPaginate) {
            $perPage = get_setting('dashboard_paginate');
            return $query->paginate($perPage)->appends(request()->query());
        }
        return $query->get();
  }
}
