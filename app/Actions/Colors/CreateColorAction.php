<?php

namespace App\Actions\Colors;

use App\DataTransferObjects\Colors\ColorDataTransfer;
use App\Models\Color;
use App\Services\CategoryService;
use App\Models\Category;
use App\DataTransferObjects\Categories\CategoryDataTransfer;
use App\Services\ColorService;
use Illuminate\Support\Facades\DB;

class CreateColorAction
{
    public static function execute(ColorDataTransfer $colorDataTransfer)
    {
        DB::transaction(function () use ($colorDataTransfer) {
            $newItem = new Color();
            $newItem->hex_code = $colorDataTransfer->hex_code;
            storeTranslatedFields($newItem, ['name'], $colorDataTransfer);
            $newItem->save();
        });
    }
}
