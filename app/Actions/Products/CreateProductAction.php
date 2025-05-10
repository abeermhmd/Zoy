<?php

namespace App\Actions\Products;

use App\Services\CategoryService;
use App\Models\Category;
use App\DataTransferObjects\Categories\CategoryDataTransfer;
use Illuminate\Support\Facades\DB;

class CreateProductAction
{
    public static function execute(CategoryDataTransfer $categoryDataTransfer)
    {
        DB::transaction(function () use ($categoryDataTransfer) {
            $categoryService = app(CategoryService::class);
            $newItem = new Category();
            $newItem->image = $categoryService->storeImage($categoryDataTransfer->image, 'categories');
            $newItem->discount = $categoryDataTransfer->discount ?? 0;
            $newItem->is_featured = $categoryDataTransfer->is_featured && $categoryDataTransfer->is_featured == 'on' ? 'yes' : 'no';
            $newItem->department = $categoryDataTransfer->department && $categoryDataTransfer->department == 'man' ? 'man' : 'women';
            storeTranslatedFields($newItem, ['name', 'key_words'], $categoryDataTransfer);
            $newItem->save();
        });
    }
}
