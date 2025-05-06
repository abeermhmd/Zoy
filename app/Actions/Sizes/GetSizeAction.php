<?php

namespace App\Actions\Sizes;

use App\Models\Size;

class GetSizeAction
{
    public static function execute(string $id): Size
    {
        return Size::query()->where('id', $id)->first();
    }
}
