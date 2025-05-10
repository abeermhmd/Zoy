<?php

namespace App\Services;

use App\Actions\Categories\{CreateCategoryAction,
    GetProductCategoriesAction,
    UpdateCategoryAction,
    GetCategoriesAction,
    GetCategoryAction};
use App\Contracts\CategoryContract;
use App\DataTransferObjects\Categories\{CategoryDataTransfer,CategoryFilterDataTransfer };
use App\Models\Category;
use App\Traits\ImageTrait;

class CategoryService implements CategoryContract
{
    use ImageTrait;

    public function getCategories(?CategoryFilterDataTransfer $filters = null)
    {
        return GetCategoriesAction::execute($filters);
    }

    public function getCategory(string $id)
    {
        return GetCategoryAction::execute($id);
    }
    public function createCategory(CategoryDataTransfer $data)
    {
        CreateCategoryAction::execute($data);
    }

    public function updateCategory(Category $category, CategoryDataTransfer $data)
    {
        UpdateCategoryAction::execute($category, $data);
    }
    public function GetProductCategoriesAction()
    {
        return GetProductCategoriesAction::execute();
    }
}
