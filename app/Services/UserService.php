<?php
namespace App\Services;

use App\Models\{User,UserAddress};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser($data) : User
    {
      return  DB::transaction(function () use ($data) {
            $user = new User();
            $user->name = $data->name;
            $user->mobile = $data->mobile; // الهاتف الذي تم دمجه في الـ UserRequest
            $user->email = $data->email;
            $user->date_of_birth = $data->date_of_birth;
            $user->password = bcrypt($data->password);
            $user->save();

            return $user;

        });
    }

    public function updateUser(User $user, $data)
    {
      return  DB::transaction(function () use ($user, $data) {
            $user->name = $data->name;
            $user->mobile = $data->mobile; // الهاتف الذي تم دمجه في الـ UserRequest
            $user->email = $data->email;
            $user->date_of_birth = $data->date_of_birth;
            $user->save();

            return $user;
        });
    }
    public function addAddressUser( $data)
    {
      return  DB::transaction(function () use ($data) {
                $newAddress = new UserAddress();
                $newAddress->user_id = auth('web')->id();
                $newAddress->title = $data->address_title;
                $newAddress->address_line_one = $data->address_line_one;
                $newAddress->address_line_two = $data->address_line_two;
                $newAddress->country_id = $data->country_id;
                $newAddress->city_id = $data->city_id;
                $newAddress->extra_directions = $data->extra_directions;
                $newAddress->postal_code = ($data->country_id == 1) ? null : $data->postal_code;
                $newAddress->save();

                return $newAddress;
        });
    }
    public function updateAddressUser($UserAddress, $data)
    {
        return DB::transaction(function () use ($UserAddress, $data) {
            $UserAddress->title = $data->address_title;
            $UserAddress->address_line_one = $data->address_line_one;
            $UserAddress->address_line_two = $data->address_line_two;
            $UserAddress->country_id = $data->country_id;
            $UserAddress->city_id = $data->city_id;
            $UserAddress->extra_directions = $data->extra_directions;
            $UserAddress->postal_code = ($data->country_id == 1) ? null : $data->postal_code;
            $UserAddress->save();

            return $UserAddress;
        });
    }

    public function updatePasswordUser(User $user): void
    {
        DB::transaction(function () use ($user) {
            $user->password = bcrypt(request()->input('password'));
            $user->save();
        });
    }

    public function changePassword(User $user, $oldPassword, $newPassword)
    {
        return DB::transaction(function () use ($user, $oldPassword, $newPassword) {
            if (!Hash::check($oldPassword, $user->password)) {
                return [
                'status' => false, 'code' => 201,'message' => __('website.errorCurrentPassword')
                ];
            }

            $user->password = bcrypt($newPassword);
            if ($user->save()) {
                $user->refresh();
                return ['status' => true,'code' => 300,'message' => __('api.ok')
                ];
            }

            return [
            'status' => false,'code' => 201,'message' => __('api.whoops')
            ];
        });
    }

}
