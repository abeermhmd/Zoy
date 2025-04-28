<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $routeName = $this->route()->getName();
        $id = $this->route('id');
        switch ($routeName) {
            case 'admins.subscribers.store':
                return [
                    'email' => 'required|email|unique:subscribers,email',
                ];
            case 'admins.subscribers.update':
                return [
                    'email' => 'required|email|unique:subscribers,email,' . $id,
                ];
            default:
                return [];
        }
    }


}
