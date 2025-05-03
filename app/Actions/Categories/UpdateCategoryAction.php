<?php

namespace App\Actions\Categories;

use App\Services\CategoryService;
use App\Models\Category;
use App\DataTransferObjects\Categories\CategoryDataTransfer;
use Illuminate\Support\Facades\DB;

class UpdateCategoryAction
{
    public static function execute($banner , CategoryDataTransfer $categoryDataTransfer)
    {
        DB::transaction(function () use ($banner , $categoryDataTransfer) {
            $service = app(CategoryService::class);
            if ($categoryDataTransfer->image) {
                $oldImage = $banner->getRawOriginal('image') ?? null;
                $banner->image = $service->storeImage($categoryDataTransfer->image, 'categories', $oldImage);
            }
            storeTranslatedFields($banner, ['name', 'key_words'], $categoryDataTransfer);
            $banner->discount = $categoryDataTransfer->discount ?? 0;
            $banner->is_featured = isset($categoryDataTransfer->is_featured) && $banner->subcategories->isEmpty() && $categoryDataTransfer->is_featured == "on" ? 'yes' : 'no';
            $banner->department = $categoryDataTransfer->department && $categoryDataTransfer->department == 'man' ? 'man' : 'women';
            $banner->save();
        });
    }
}
