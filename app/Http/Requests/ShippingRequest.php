<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ShippingRequest extends FormRequest
{
    protected $locales;

    public function __construct()
    {
        $this->locales = Language::all()->pluck('lang');
    }

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
            case 'admins.update.shipping.content':
                return array_reduce($this->locales->toArray(), function ($rules, $locale) {
                    $rules['shipping_content_kuwait_' . $locale] = 'required';
                    $rules['shipping_content_outside_kuwait_' . $locale] = 'required';
                    return $rules;
                }, []);

            case 'admins.update.shipping.prices':
                return [
                    'countries.*.id' => 'required|exists:countries,id',
                    'countries.*.delivery_fees' => 'required|numeric|min:0',
                    'cities.*.id' => 'required|exists:cities,id',
                    'cities.*.delivery_fees' => 'required|numeric|min:0',
                ];
            default:
        return [];
        }
    }
}
