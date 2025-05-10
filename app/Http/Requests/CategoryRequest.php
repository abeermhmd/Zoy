<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    protected $locales;
    public function __construct()
    {
        $this->locales = Language::all()->pluck('lang');
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $routeName = $this->route()->getName();
        $languageRules = array_reduce($this->locales->toArray(), function ($rules, $locale) {
            $rules['name_' . $locale] = 'required';
            $rules['key_words_' . $locale] = 'nullable';
            return $rules;
        }, []);

        switch ($routeName) {
            case 'admins.categories.store':
                $baseRules = [
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
                    'discount' => 'nullable|numeric|min:0|max:100',
                ];
                break;

            case 'admins.categories.update':
                 $baseRules = [
                    'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                    'discount' => 'nullable|numeric|min:0|max:100',
                 ];
                break;
            case 'admins.subCategories.store':
                 $baseRules = [
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
                    'parent_id' => 'required|exists:categories,id',
                 ];
                break;
            case 'admins.subCategories.update':
               $baseRules = [
                    'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                    'parent_id' => 'required|exists:categories,id',
               ];
            break;
        }
        $rules = array_merge($baseRules, $languageRules);

        return $rules;
    }
}
