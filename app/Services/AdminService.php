<?php

namespace App\Services;

use App\Models\Admin;
use App\Actions\Admins\{CreateAdminAction,
    UpdateAdminAction,
    GetAdminAction,
    GetAdminsAction,
    UpdateMyPasswordAdminAction
};
use App\Contracts\AdminContract;
use App\DataTransferObjects\Admins\{AdminDataTransfer, AdminFilterDataTransfer};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminService implements AdminContract
{

    public function getAdmins(?AdminFilterDataTransfer $filters = null): LengthAwarePaginator|Collection
    {
        return GetAdminsAction::execute($filters);
    }

    public function getAdmin(string $id): Admin
    {
        return GetAdminAction::execute($id);
    }

    public function createAdmin(AdminDataTransfer $data): void
    {
        CreateAdminAction::execute($data);
    }

    public function updateAdmin(Admin $admin, AdminDataTransfer $data): void
    {
        UpdateAdminAction::execute($admin, $data);
    }

    public function updateProfileAdmin(Admin $admin, AdminDataTransfer $data): void
    {
        UpdateAdminAction::execute($admin, $data);
    }

    public function updateMyPassword(Admin $admin, AdminDataTransfer $data): void
    {
        UpdateMyPasswordAdminAction::execute($admin, $data);
    }
}
