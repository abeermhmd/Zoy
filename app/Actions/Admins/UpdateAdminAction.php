<?php

namespace App\Actions\Admins;

use App\DataTransferObjects\Admin\AdminDataTransfer;
use App\Models\{Admin, UserPermission};
use Illuminate\Support\Facades\DB;

class UpdateAdminAction
{
    public static function execute(Admin $admin, AdminDataTransfer $adminDataTransfer)
    {
        DB::transaction(function () use ($admin, $adminDataTransfer) {
            $admin->update([
                'name' => $adminDataTransfer->name,
                'email' => $adminDataTransfer->email,
                'mobile' => $adminDataTransfer->mobile,
            ]);

            if ($adminDataTransfer->permissions) {
                $roles = implode(',', $adminDataTransfer->permissions);
                UserPermission::updateOrCreate(
                    ['user_id' => $admin->id],
                    ['permission' => $roles]
                );
            }
        });
    }
}
