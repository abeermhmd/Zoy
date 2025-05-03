<?php

namespace App\Actions\SubCategories;

use App\DataTransferObjects\SubCategories\SubCategoryDataTransfer;
use App\Models\Category;
use App\Services\SubCategoryService;
use Illuminate\Support\Facades\DB;

class CreateSubCategoryAction
{
    public static function execute(SubCategoryDataTransfer $subCategoryDataTransfer)
    {
        DB::transaction(function () use ($subCategoryDataTransfer) {
            $subCategoryService = app(SubCategoryService::class);
            $newItem = new Category();
            $newItem->image = $subCategoryService->storeImage($subCategoryDataTransfer->image, 'categories');
            $newItem->is_featured = isset($subCategoryDataTransfer->is_featured) && $subCategoryDataTransfer->is_featured == 'on' ? 'yes' : 'no';
            $newItem->parent_id = $subCategoryDataTransfer->parent_id;
            $subCategoryService->updateParentCategoryFeaturedStatus($subCategoryDataTransfer->parent_id);
            storeTranslatedFields($newItem, ['name', 'key_words'], $subCategoryDataTransfer);
            $newItem->save();
        });
    }
}
