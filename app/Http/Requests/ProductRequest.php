<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

class ProductRequest extends FormRequest
{
    protected $locales;

    public function __construct()
    {
        parent::__construct();
        $this->locales = Language::all()->pluck('lang');
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $routeName = $this->route()->getName();
        $languageRules = array_reduce($this->locales->toArray(), function ($rules, $locale) {
            $rules['name_' . $locale] = 'required';
            $rules['description_' . $locale] = 'required';
            $rules['key_words_' . $locale] = 'nullable';
            return $rules;
        }, []);

        switch ($routeName) {
            case 'admins.products.store':
                $baseRules = [
                    'image' => 'required|image|mimes:jpeg,png,jpg|max:1024',
                    'size_guide_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                    'price' => 'required|numeric|min:0|max:99999999.99',
                    'price_offer' => 'nullable|numeric|min:0|max:99999999.99|lt:price',
                    'quantity' => 'required_if:has_variants,0|numeric|min:0',
                    'weight' => 'required|numeric|min:0',
                    'category_id' => 'required|integer|exists:categories,id',
                    'sku' => 'required|string|unique:products,sku',
                ];
                break;

            case 'admins.products.update':
                $baseRules = [
                    'image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                    'size_guide_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
                    'price' => 'required|numeric|min:0',
                    'price_offer' => 'nullable|numeric|min:0|lt:price',
                    'quantity' => 'required|numeric|min:0',
                    'weight' => 'required|numeric|min:0',
                    'category_id' => 'required|integer|exists:categories,id',
                    'sku' => [
                        'nullable',
                        'string',
                        Rule::unique('products', 'sku')->ignore($this->route('product')),
                    ],
                ];
                break;

            case 'admins.products.update.quantites':
                $languageRules = [];
                $baseRules = [
                    'ids' => 'required|array',
                    'ids.*' => 'required|integer',
                    'quantities' => 'required|array|size:' . count($this->input('ids', [])),
                    'quantities.*' => 'required|numeric|min:0',
                    'skus' => 'required|array|size:' . count($this->input('ids', [])),
                    'skus.*' => [
                        'required',
                        'string',
                        function ($attribute, $value, $fail) {
                            // Get the current product ID
                            $productId = $this->route('product');

                            // Get the index from the attribute name (e.g., 'skus.0' => 0)
                            preg_match('/skus\.(\d+)/', $attribute, $matches);
                            $index = $matches[1] ?? null;

                            // Get the corresponding variant ID if index is available
                            $variantId = null;
                            if ($index !== null) {
                                $ids = $this->input('ids', []);
                                if (array_key_exists($index, $ids)) {
                                    $variantId = $ids[$index];
                                }
                            }

                            // Fail if variantId is missing
                            if ($variantId === null) {
                                $locale = App::getLocale();
                                $fail($locale == 'ar' ? 'معرف المتغير غير صالح.' : 'Invalid variant ID.');
                                return;
                            }

                            // Get variant details (color and size information)
                            $colorName = null;
                            $sizeName = null;
                            $variantType = null;

                            $variant = DB::table('product_color_sizes')
                                ->select('id', 'product_id', 'color_id', 'size_id')
                                ->where('id', $variantId)
                                ->first();

                            if ($variant) {
                                $product = DB::table('products')
                                    ->select('type_variants')
                                    ->where('id', $variant->product_id)
                                    ->first();

                                if ($product) {
                                    $variantType = $product->type_variants;

                                    // Get color name if applicable
                                    if (in_array($variantType, [1, 2]) && $variant->color_id) { // Type 1 or 2 have colors
                                        $color = DB::table('colors')
                                            ->join('color_translations', 'colors.id', '=', 'color_translations.color_id')
                                            ->select('color_translations.name')
                                            ->where('colors.id', $variant->color_id)
                                            ->where('color_translations.locale', App::getLocale())
                                            ->first();

                                        if ($color) {
                                            $colorName = $color->name;
                                        } else {
                                            // Fallback to a default locale (e.g., 'en')
                                            $color = DB::table('colors')
                                                ->join('color_translations', 'colors.id', '=', 'color_translations.color_id')
                                                ->select('color_translations.name')
                                                ->where('colors.id', $variant->color_id)
                                                ->where('color_translations.locale', 'en')
                                                ->first();
                                            $colorName = $color ? $color->name : null;
                                        }
                                    }

                                    // Get size name if applicable
                                    if (in_array($variantType, [1, 3]) && $variant->size_id) { // Type 1 or 3 have sizes
                                        $size = DB::table('sizes')
                                            ->join('size_translations', 'sizes.id', '=', 'size_translations.size_id')
                                            ->select('size_translations.name')
                                            ->where('sizes.id', $variant->size_id)
                                            ->where('size_translations.locale', App::getLocale())
                                            ->first();

                                        if ($size) {
                                            $sizeName = $size->name;
                                        } else {
                                            // Fallback to a default locale (e.g., 'en')
                                            $size = DB::table('sizes')
                                                ->join('size_translations', 'sizes.id', '=', 'size_translations.size_id')
                                                ->select('size_translations.name')
                                                ->where('sizes.id', $variant->size_id)
                                                ->where('size_translations.locale', 'en')
                                                ->first();
                                            $sizeName = $size ? $size->name : null;
                                        }
                                    }
                                }
                            }

                            // Check if SKU exists in products table (exclude current product)
                            $existsInProducts = DB::table('products')
                                ->where('sku', $value)
                                ->where('id', '!=', $productId)
                                ->exists();

                            // Check if SKU exists in product_color_sizes table (exclude current variant)
                            $existsInVariants = DB::table('product_color_sizes')
                                ->where('sku', $value)
                                ->where('id', '!=', $variantId)
                                ->exists();

                            if ($existsInProducts || $existsInVariants) {
                                // Get the current application locale
                                $locale = App::getLocale();

                                // Prepare the error message based on variant type and locale
                                if ($variantType !== null && ($colorName !== null || $sizeName !== null)) {
                                    if ($locale == 'ar') {
                                        // Arabic messages with variant info
                                        switch ($variantType) {
                                            case 1: // Color and size
                                                $fail("رمز المنتج (SKU) للون \"{$colorName}\" والحجم \"{$sizeName}\" يجب أن يكون فريدًا.");
                                                break;
                                            case 2: // Color only
                                                $fail("رمز المنتج (SKU) للون \"{$colorName}\" يجب أن يكون فريدًا.");
                                                break;
                                            case 3: // Size only
                                                $fail("رمز المنتج (SKU) للحجم \"{$sizeName}\" يجب أن يكون فريدًا.");
                                                break;
                                        }
                                    } else {
                                        // English messages with variant info
                                        switch ($variantType) {
                                            case 1: // Color and size
                                                $fail("The SKU for color \"{$colorName}\" and size \"{$sizeName}\" must be unique.");
                                                break;
                                            case 2: // Color only
                                                $fail("The SKU for color \"{$colorName}\" must be unique.");
                                                break;
                                            case 3: // Size only
                                                $fail("The SKU for size \"{$sizeName}\" must be unique.");
                                                break;
                                        }
                                    }
                                } else {
                                    // Generic fallback messages
                                    if ($locale == 'ar') {
                                        $fail("رمز المنتج (SKU) يجب أن يكون فريدًا.");
                                    } else {
                                        $fail("The SKU must be unique across all products and variants.");
                                    }
                                }
                            }
                        },
                    ],
                ];
                break;
        }

        $rules = array_merge($baseRules ?? [], $languageRules);

        return $rules;
    }
}
