<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
        $rules = [
            'type_link' => 'required|integer|min:1|max:4',
            'product_id' => 'required_if:type_link,==,2',
            'category_id' => 'required_if:type_link,==,3',
            'sub_category_id' => 'required_if:type_link,==,4',
        ];
        switch ($routeName) {
            case 'admins.banners.store':
                $rules['image'] = 'required|mimes:jpeg,bmp,png,gif';
                $rules['type'] = 'required|integer|min:1|max:2';
                $rules['url'] = 'required_if:type,==,2';
                break;

            case 'admins.banners.update':
                $rules['type'] = 'required|integer|min:1|max:2';
                $rules['image'] = 'nullable|mimes:jpeg,bmp,png,gif';
                break;

            case 'admins.bannerAdUpdate':
            case 'admins.adPopUpdate':
                 $rules = [
                    'image' => 'nullable|mimes:jpeg,bmp,png,gif',
                    'type_link' => 'required|integer|min:1|max:4',
                    'product_id' => 'required_if:type_link,==,2',
                    'category_id' => 'required_if:type_link,==,3',
                    'sub_category_id' => 'required_if:type_link,==,4',
                     'type' => 'nullable',
                 ];
                break;
            }

            return $rules;

    }
}
