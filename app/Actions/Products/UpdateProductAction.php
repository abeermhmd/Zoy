<?php

namespace App\Actions\Products;

use App\Services\CategoryService;
use App\Models\Category;
use App\DataTransferObjects\Categories\CategoryDataTransfer;
use Illuminate\Support\Facades\DB;

class UpdateProductAction
{
    public static function execute($category , CategoryDataTransfer $categoryDataTransfer)
    {
        DB::transaction(function () use ($category , $categoryDataTransfer) {
            $service = app(CategoryService::class);
            if ($categoryDataTransfer->image) {
                $oldImage = $category->getRawOriginal('image') ?? null;
                $category->image = $service->storeImage($categoryDataTransfer->image, 'categories', $oldImage);
            }
            storeTranslatedFields($category, ['name', 'key_words'], $categoryDataTransfer);
            $category->discount = $categoryDataTransfer->discount ?? 0;
            $category->is_featured = isset($categoryDataTransfer->is_featured) && $category->subcategories->isEmpty() && $categoryDataTransfer->is_featured == "on" ? 'yes' : 'no';
            $category->department = $categoryDataTransfer->department && $categoryDataTransfer->department == 'man' ? 'man' : 'women';
            $category->save();
        });
    }
}
