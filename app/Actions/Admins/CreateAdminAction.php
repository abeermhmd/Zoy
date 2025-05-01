<?php

namespace App\Actions\Admins;

use App\DataTransferObjects\Admin\AdminDataTransfer;
use App\Models\{Admin, UserPermission};
use Illuminate\Support\Facades\DB;

class CreateAdminAction
{
    public static function execute(AdminDataTransfer $adminDataTransfer)
    {
        DB::transaction(function () use ($adminDataTransfer) {
            $newAdmin = Admin::create([
                'name' => $adminDataTransfer->name,
                'email' => $adminDataTransfer->email,
                'mobile' => $adminDataTransfer->mobile,
                'password' => bcrypt($adminDataTransfer->password),
            ]);

            if ($adminDataTransfer->permissions) {
                $roles = implode(',', $adminDataTransfer->permissions);
                UserPermission::create([
                    'user_id' => $newAdmin->id,
                    'permission' => $roles
                ]);
            }
        });
    }
}
