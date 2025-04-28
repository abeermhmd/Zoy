<?php

namespace App\Services;

use App\Models\Color;
use Illuminate\Support\Facades\DB;

class ColorService {
    public function createColor($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Color();
            storeTranslatedFields($newItem , ['name'] , $data);
            $newItem->hex_code = $data->hex_code;
            $newItem->save();
        });
    }
    public function updateColor(Color $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            storeTranslatedFields($item , ['name'] , $data );
            $item->hex_code = $data->hex_code;
            $item->save();
        });
    }

}
