<?php

namespace App\Services;

use App\Models\Permission;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\DB;

class PermissionService {
    use ImageTrait;
    public function createPermission($data): void
    {
        DB::transaction(function () use ($data) {
            $newItem = new Permission();
            storeTranslatedFields($newItem , ['name'] , $data);
            $newItem->roleSlug = $data->roleSlug;
            $newItem->save();
        });
    }
    public function updatePermission(Permission $item, $data): void
    {
        DB::transaction(function () use ($data , $item) {
            storeTranslatedFields($item , ['name'] , $data );
            $item->roleSlug = $data->roleSlug;
            $item->save();
        });

    }
}
