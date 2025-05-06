<?php

namespace App\Actions\Colors;

use App\DataTransferObjects\Colors\ColorDataTransfer;
use Illuminate\Support\Facades\DB;

class UpdateColorAction
{
    public static function execute($color ,ColorDataTransfer $colorDataTransfer)
    {
        DB::transaction(function () use ($color , $colorDataTransfer) {
            $color->hex_code = $colorDataTransfer->hex_code;
            storeTranslatedFields($color, ['name'], $colorDataTransfer);
            $color->save();
        });
    }
}
