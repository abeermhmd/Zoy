<?php

namespace App\Actions\Sizes;

use App\DataTransferObjects\Sizes\SizeDataTransfer;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class CreateSizeAction
{
    public static function execute(SizeDataTransfer $sizeDataTransfer)
    {
        DB::transaction(function () use ($sizeDataTransfer) {
            $newItem = new Size();
            storeTranslatedFields($newItem, ['name'], $sizeDataTransfer);
            $newItem->save();
        });
    }
}
