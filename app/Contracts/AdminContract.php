<?php

namespace App\Contracts;

use App\DataTransferObjects\Admins\{AdminDataTransfer,AdminFilterDataTransfer};
use App\Models\Admin;

interface AdminContract
{
    public function getAdmins(?AdminFilterDataTransfer $filters = null);
    public function getAdmin(string $id);
    public function createAdmin(AdminDataTransfer $data);
    public function updateAdmin(Admin $admin ,AdminDataTransfer $data);
    public function updateProfileAdmin(Admin $admin ,AdminDataTransfer $data);
    public function updateMyPassword(Admin $admin ,AdminDataTransfer $data);

}
