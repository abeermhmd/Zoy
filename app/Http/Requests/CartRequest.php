<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $routeName = $this->route()->getName();

        switch ($routeName) {
            case 'addProductToCart':
                return [
                    'product_id' => 'required|exists:products,id',
                    'quantity' => 'required|gt:0',
                    'product_color_size_id' => 'nullable|exists:product_color_sizes,id',
                ];
                case 'notifyMe':
                case 'deleteProductCart':
                return [
                    'product_id' => 'required|exists:products,id',
                    'product_color_size_id' => 'nullable|exists:product_color_sizes,id',
                ];
            case 'checkPromo':
                if (auth('web')->check()) {
                    return [
                        'code_name' => 'required',
                        'address_id' => 'required|exists:user_addresses,id',
                    ];
                } else {
                    return [
                        'code_name' => 'required',
                        'country_id' => 'required|exists:countries,id',
                        'city_id' => 'nullable|exists:cities,id',
                    ];
                }
            default:
                return [];
        }
    }
}
