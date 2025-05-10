<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->has('introduction') && $this->has('mobile')) {
            $this->merge([
                'mobile' => $this->input('introduction') . $this->input('mobile'),
            ]);
        }

        $routeName = $this->route()->getName();

        if ($routeName == 'updateProfile') {
            $id = auth('web')->user()->id;
        } else {
            $id = $this->route('id');
        }

        $rules = [];

        switch ($routeName) {
            case 'admins.users.store':
            case 'register':
                $rules = [
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                    'date_of_birth' => 'required|date|before:today',
                    'mobile' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|digits_between:8,14|unique:users,mobile',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password|min:6',
                ];
                break;

            case 'admins.users.update':
            case 'updateProfile':
                $rules = [
                    'name' => 'required',
                    'date_of_birth' => 'required|date|before:today',
                    'email' => 'required|email|unique:users,email,' . $id,
                    'mobile' => 'nullable|digits_between:8,14|unique:users,mobile,' . $id,
                ];
                break;

            case 'admins.users.update_password':
                $rules = [
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password|min:6',
                ];
                break;

            case 'changePasswordPost':
                $rules = [
                    'old_password' => 'required',
                    'new_password' => 'required|min:6',
                    'confirm_password' => 'required|min:6|same:new_password',
                ];
                break;

            case 'addAddress':
            case 'updateAddress':
                $rules = [
                    'address_title' => 'required',
                    'address_line_one' => 'required',
                    'address_line_two' => 'nullable',
                    'country_id' => 'required|exists:countries,id',
                    'city_id' => 'required|exists:cities,id',
                    'extra_directions' => 'nullable',
                    'postal_code' => 'nullable',
                ];
                break;
        }

        if ($routeName === 'register') {
            $rules['recaptcha_token'] = 'required|string';
        }

        return $rules;
    }


}
