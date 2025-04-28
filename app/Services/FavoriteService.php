<?php

namespace App\Services;

use App\Models\{Favorite, Product};
use Illuminate\Support\Facades\DB;

class FavoriteService
{
    public function addToFavorite($data)
    {
        return DB::transaction(function () use ($data) {
            Product::findOrFail($data->product_id);
            $check = Favorite::where('user_id', auth('web')->id())->where('product_id', $data->product_id)->first();
            if ($check) {
                $check->forceDelete();
            }

            return Favorite::create([
                'product_id' => $data->product_id,
                'user_id' => auth('web')->id(),
            ]);
        });
    }

    public function removeFavorite($data)
    {
        DB::transaction(function () use ($data) {
            Product::findOrFail($data->product_id);
            Favorite::where('user_id', auth('web')->id())->where('product_id', $data->product_id)->forceDelete();
        });
    }

}
