<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $routeName = $this->route()->getName();
        switch ($routeName) {
            case 'admins.admins.store':
                return [
                    'name' => 'required|string',
                    'email' => 'required|email|unique:admins,email',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password|min:6',
                    'mobile' => 'required|digits_between:8,13|unique:admins,mobile',
                ];

            case 'admins.admins.update':
                return [
                    'name' => 'required|string',
                    'mobile' => 'required|digits_between:8,12|unique:admins,mobile,' . $this->route('admin'),
                    'email' => 'required|email|unique:admins,email,' . $this->route('admin'),
                ];

            case 'admins.admins.updateProfile':
                return [
                    'name' => 'required|string',
                    'mobile' => 'required|digits_between:8,12|unique:admins,mobile,' . auth()->guard('admin')->user()->id,
                    'email' => 'required|email|unique:admins,email,' . auth()->guard('admin')->user()->id,
                ];

            case 'admins.admins.edit_password':
                return [
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password|min:6',
                ];

            default:
                return [];
        }
    }
}
