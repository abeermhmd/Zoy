<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
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
        $rules = [
            'payment_method' => 'required|integer|min:1|max:5', // 1->Knet, 2->Visa, 3->Mastercard, 4->Apple Pay, 5->Samsung Pay
        ];

        if (Auth::guard('web')->check()) {
            $rules = array_merge($rules, [
                'address_id' => 'required|exists:user_addresses,id',
            ]);
        } else {
            $rules = array_merge($rules, [
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'mobile' => 'required|digits_between:8,14',
                'country_id' => 'required|exists:countries,id',
                'city_id' => 'required|exists:cities,id',
                'address_line_one' => 'required|string|max:255',
            ]);
        }

        return $rules;
    }
}
