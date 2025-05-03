<?php

namespace App\Actions\Admins;

use App\DataTransferObjects\Admins\AdminDataTransfer;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class UpdateMyPasswordAdminAction
{
    public static function execute(Admin $admin, AdminDataTransfer $adminDataTransfer)
    {
        DB::transaction(function () use ($admin, $adminDataTransfer) {
            $admin->password = bcrypt(request()->input('password'));
            $admin->save();
        });
    }
}
