<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $languageRules = array_reduce($this->locales->toArray(), function ($rules, $locale) {
            $rules['name_' . $locale] = 'required';
            return $rules;
        }, []);

       $baseRules = [
        'roleSlug' => 'required|unique:permissions,roleSlug,' . ($this->route('permission') ?? 'NULL') . ',id',
       ];

        $rules = array_merge($baseRules, $languageRules);

        return $rules;
    }
}
