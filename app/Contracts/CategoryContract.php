<?php

namespace App\Contracts;

use App\Models\Category;
use App\DataTransferObjects\Categories\{CategoryDataTransfer, CategoryFilterDataTransfer};

interface CategoryContract
{
    public function getCategories(?CategoryFilterDataTransfer $filters = null);

    public function getCategory(string $id);

    public function GetProductCategoriesAction();

    public function createCategory(CategoryDataTransfer $data);

    public function updateCategory(Category $category, CategoryDataTransfer $data);
}
