<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;

class CategoryService {
    use ImageTrait;
    public function createCategory($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Category();
            $newItem->image = $this->storeImage($data->file('image'), 'categories');
            $newItem->discount = $data['discount'] ?? 0;
            $newItem->is_featured = $data->has('is_featured') && $data->is_featured == 'on' ? 'yes' : 'no';
            $newItem->department = $data->has('department') && $data->department == 'man' ? 'man' : 'women';
            storeTranslatedFields($newItem , ['name' ,'key_words'] , $data);
            $newItem->save();
        });
    }
    public function updateCategory(Category $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            if ($data->hasFile('image')) {
                $item->image = $this->storeImage($data->file('image'), 'categories' , $item->getRawOriginal('image') ?
                $item->getRawOriginal('image') : null);
            }
            storeTranslatedFields($item , ['name','key_words'] , $data );
            $item->discount = $data['discount'] ?? 0;
            $item->is_featured = isset($data->is_featured) && $data->is_featured == "on" ? 'yes' : 'no';
            $item->department = $data->has('department') && $data->department == 'man' ? 'man' : 'women';
            $item->save();
        });
    }
    public function createSubCategory($data): void
    {
        DB::transaction(function () use ($data) {
        $newItem = new Category();
        $newItem->image = $this->storeImage($data->file('image'), 'categories');
        $newItem->is_featured = $data->has('is_featured') && $data->is_featured == 'on' ? 'yes' : 'no';
        $newItem->parent_id = $data->parent_id;
        storeTranslatedFields($newItem , ['name' , 'key_words'] , $data);
        $newItem->save();
        });
    }
    public function updateSubCategory(Category $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            if ($data->hasFile('image')) {
            $item->image = $this->storeImage($data->file('image'), 'categories' , $item->getRawOriginal('image') ?
            $item->getRawOriginal('image') : null);
            }
            storeTranslatedFields($item , ['name' , 'key_words'] , $data );
            $item->is_featured = isset($data->is_featured) && $data->is_featured == "on" ? 'yes' : 'no';
            $item->parent_id = $data->parent_id;
            $item->save();
        });
    }
}
