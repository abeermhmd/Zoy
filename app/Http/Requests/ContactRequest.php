<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $routeName = $this->route()->getName();
        switch ($routeName) {
            case 'admins.contact.update':
                return [
                    'status' => 'required|integer|min:1|max:1',
                ];
            case 'contactUsPost':
                return [
                 'message' => 'required',
                 'name' => 'required',
                 'email' => 'required|email',
                 'introduction' => 'required',
                 'mobile' => 'required|digits_between:8,13',
                ];

            default:
            return [];
        }

    }
}
