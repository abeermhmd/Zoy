<?php

namespace App\Services;

use App\Models\Size;
use Illuminate\Support\Facades\DB;

class SizeService {
    public function createSize($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Size();
            storeTranslatedFields($newItem , ['name'] , $data);
            $newItem->save();
        });
    }
    public function updateSize(Size $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            storeTranslatedFields($item , ['name'] , $data );
            $item->save();
        });
    }

}
