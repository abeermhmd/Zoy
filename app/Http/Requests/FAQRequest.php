<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

class FAQRequest extends FormRequest
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
        return array_reduce($this->locales->toArray(), function ($rules, $locale) {
            $rules['answer_' . $locale] = 'required';
            $rules['question_' . $locale] = 'required';
            return $rules;
        }, []);


    }
}
