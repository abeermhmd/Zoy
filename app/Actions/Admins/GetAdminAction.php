<?php

namespace App\Actions\Admins;

use App\Models\Admin;

class GetAdminAction
{
    public static function execute(string $id): Admin
    {
        return Admin::query()->where('id', $id)->first();
    }
}
