<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    public function __construct()
    {
        $this->locales = Language::all()->pluck('lang');
    }
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
        $baseRules = [
            'image' => $routeName === 'admins.pages.store'
                ? 'required|mimes:jpeg,bmp,png,gif'
                : 'mimes:jpeg,bmp,png,gif',
        ];

        $languageRules = array_reduce($this->locales->toArray(), function ($rules, $locale) {
            $rules['description_' . $locale] = 'required';
            return $rules;
        }, []);

        return array_merge($baseRules, $languageRules);
    }
}
