<?php

namespace App\Services;

use App\Actions\SubCategories\{CreateSubCategoryAction,
    GetSubCategoriesAction,
    GetSubCategoryAction,
    UpdateSubCategoryAction};
use App\Contracts\SubCategoryContract;
use App\DataTransferObjects\SubCategories\{SubCategoryDataTransfer, SubCategoryFilterDataTransfer};
use App\Models\Category;
use App\Traits\ImageTrait;

class SubCategoryService implements SubCategoryContract
{
    use ImageTrait;

    public function getSubCategories(?SubCategoryFilterDataTransfer $filters = null)
    {
       return GetSubCategoriesAction::execute($filters);
    }

    public function getSubCategory(string $id)
    {
       return GetSubCategoryAction::execute($id);
    }

    public function createSubCategory(SubCategoryDataTransfer $data)
    {
         CreateSubCategoryAction::execute($data);
    }

    public function updateSubCategory(Category $category, SubCategoryDataTransfer $data)
    {
        UpdateSubCategoryAction::execute($category, $data);
    }

    public function updateParentCategoryFeaturedStatus($parentId): void
    {
        if ($parentId) {
            $parentCategory = Category::findOrFail($parentId);
            if ($parentCategory && $parentCategory->is_featured == 'yes') {
                $parentCategory->is_featured = 'no';
                $parentCategory->save();
            }
        }
    }

}
