<?php

namespace App\Actions\Colors;

use App\Models\Color;

class GetColorAction
{
    public static function execute(string $id): Color
    {
        return Color::query()->where('id', $id)->first();
    }
}
