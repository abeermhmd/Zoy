<?php

namespace App\Contracts;

use App\Models\Category;
use App\DataTransferObjects\SubCategories\{SubCategoryDataTransfer, SubCategoryFilterDataTransfer};

interface SubCategoryContract
{
    public function getSubCategories(?SubCategoryFilterDataTransfer $filters = null);

    public function getSubCategory(string $id);

    public function createSubCategory(SubCategoryDataTransfer $data);

    public function updateSubCategory(Category $category, SubCategoryDataTransfer $data);
}
