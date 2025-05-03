<?php

namespace App\Actions\SubCategories;

use App\DataTransferObjects\SubCategories\SubCategoryDataTransfer;
use App\Services\CategoryService;
use App\Models\Category;
use App\DataTransferObjects\Categories\CategoryDataTransfer;
use App\Services\SubCategoryService;
use Illuminate\Support\Facades\DB;

class UpdateSubCategoryAction
{
    public static function execute($subcategory , SubCategoryDataTransfer $subCategoryDataTransfer)
    {
        DB::transaction(function () use ($subcategory , $subCategoryDataTransfer) {
            $service = app(SubCategoryService::class);
            if ($subCategoryDataTransfer->image) {
                $oldImage = $subcategory->getRawOriginal('image') ?? null;
                $subcategory->image = $service->storeImage($subCategoryDataTransfer->image, 'categories', $oldImage);
            }
            storeTranslatedFields($subcategory, ['name', 'key_words'], $subCategoryDataTransfer);
            $subcategory->is_featured = isset($subCategoryDataTransfer->is_featured) && $subCategoryDataTransfer->is_featured == "on" ? 'yes' : 'no';
            $subcategory->parent_id = $subCategoryDataTransfer->parent_id;
            $service->updateParentCategoryFeaturedStatus($subCategoryDataTransfer->parent_id);
            $subcategory->save();
        });
    }
}
