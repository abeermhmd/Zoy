<?php

namespace App\Http\Requests;
use App\Models\Language;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
        $baseRules = [
            'mobile' => 'required|numeric',
            'whatsApp' => 'required|numeric',
            'info_email' => 'required|email',
            'dashboard_paginate' => 'required|numeric',
            'website_paginate' => 'required|numeric',
            'instagram' => 'required|url',
            'map_location_pinpoint' => 'required',
            'BHD' => 'required|numeric|min:0',
            'OMR' => 'required|numeric|min:0',
            'QAR' => 'required|numeric|min:0',
            'SAR' => 'required|numeric|min:0',
            'AED' => 'required|numeric|min:0',
        ];

        $languageRules = array_reduce($this->locales->toArray(), function ($rules, $locale) {
            $rules['title_' . $locale] = 'required';
            $rules['instagram_text_footer_' . $locale] = 'required';
            $rules['area_' . $locale] = 'required';
            $rules['block_' . $locale] = 'required';
            $rules['street_' . $locale] = 'required';
            $rules['address_' . $locale] = 'required';
            return $rules;
        }, []);
        return array_merge($baseRules, $languageRules);
    }
}
