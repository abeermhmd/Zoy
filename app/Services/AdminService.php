<?php

namespace App\Services;

use App\Models\{Admin,UserPermission};

class AdminService {
    public function createAdmin($data): Admin
    {
        $newAdmin = Admin::create([
            'name' => $data->name,
            'email' => $data->email,
            'mobile' => $data->mobile,
            'password' => bcrypt($data->password),
            'status' => 'active',
        ]);

        if ($data->permissions) {
            $roles = implode(',', $data->permissions);
            UserPermission::create([
                'user_id' => $newAdmin->id,
                'permission' => $roles
            ]);
        }

        return $newAdmin;
    }
    public function updateAdmin(Admin $admin, $data): void {

            $admin->update([
                'name' => $data->name,
                'email' => $data->email,
                'mobile' => $data->mobile,
            ]);

            if ($data->permissions) {
                $roles = implode(',', $data->permissions);
                UserPermission::updateOrCreate(
                    ['user_id' => $admin->id],
                    ['permission' => $roles]
            );
        }
    }

    public function updateProfileAdmin(Admin $admin, $data): void
    {
        $admin->update([
            'name' => $data->name,
            'mobile' => $data->mobile,
            'email' => $data->email,
        ]);
    }

    public function updatePasswordAdmin(Admin $admin, $data): void
    {
        if ($data->password) {
            $admin->password = bcrypt(request()->input('password'));
            $admin->save();
        }
    }
}
