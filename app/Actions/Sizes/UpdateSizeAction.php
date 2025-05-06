<?php

namespace App\Actions\Sizes;

use App\DataTransferObjects\Sizes\SizeDataTransfer;
use Illuminate\Support\Facades\DB;

class UpdateSizeAction
{
    public static function execute($size ,SizeDataTransfer $sizeDataTransfer)
    {
        DB::transaction(function () use ($size , $sizeDataTransfer) {
            storeTranslatedFields($size, ['name'], $sizeDataTransfer);
            $size->save();
        });
    }
}
