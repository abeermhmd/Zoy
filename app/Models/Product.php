<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use App\Traits\WithFilters;

class Product extends Model
{
    use SoftDeletes, Translatable, WithFilters;

    public $translatedAttributes = ['name', 'description', 'key_words'];
    protected $hidden = ['updated_at', 'deleted_at', 'translations'];
    protected $appends = ['is_favourite', 'currency', 'is_cart', 'color_size_is_cart'];
    protected $guarded = [];

    /**
     * The fields that can be filtered with their configurations.
     *
     * @var array
     */
    protected $filterableFields = [
        'status' => ['operator' => '=', 'method' => 'where'],
        'id' => ['operator' => '=', 'method' => 'where'],
        'category_id' => ['operator' => '=', 'method' => 'where'],
        'name' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
        'search' => ['operator' => 'like', 'method' => 'searchMethod'],
    ];
    /**
     * Custom method to handle the 'search' filter
     */
    public function searchMethod($query, $value)
    {
        return $query->where(function ($q) use ($value) {
            $q->whereTranslationLike('name', '%' . $value . '%')
                ->where('quantity', '>', 0);
        });
    }
    public function getImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
                return url('uploads/images/products/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }

    public function getSizeGuideImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
                return url('uploads/images/products/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productColorSizes()
    {
        return $this->hasMany(ProductColorSize::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function similarProducts()
    {
        return $this->hasMany(ProductSimilar::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getIsCartAttribute()
    {
        if (auth('web')->check()) {
            $cart = Cart::where(['product_id' => $this->id, 'product_color_size_id' => null])->where('user_id', auth('web')->id())->first();
        } else {
            $cart = Cart::where(['user_key' => Session::get('cart.ids'), 'product_id' => $this->id, 'product_color_size_id' => null])->where('user_id', null)->first();
        }

        return $cart ? (int)$cart->quantity : 0;
    }

    public function getColorSizeIsCartAttribute()
    {
        $ids = ProductColorSize::where('product_id', $this->id)->pluck('id')->toArray();
        if (auth('web')->check()) {
            return Cart::where('product_id', $this->id)->whereIn('product_color_size_id', $ids)->where('user_id', auth('web')->id())->pluck('product_color_size_id')->toArray();
        } else {
            return Cart::where(['user_key' => Session::get('cart.ids'), 'product_id' => $this->id])->whereIn('product_color_size_id', $ids)->where('user_id', null)->pluck('product_color_size_id')->toArray();
        }
    }

    public function getIsFavouriteAttribute()
    {
        return auth('web')->check() && Favorite::where('product_id', $this->id)
            ->where('user_id', auth('web')->id())->exists() ? 1 : 0;
    }

    public function getPriceAttribute($value)
    {
        $currency = $this->getCurrency();
        return $this->convertCurrency($value, $currency);
    }

    public function getPriceOfferAttribute($value)
    {
        $newPrice = $this->calculateDiscountedPrice($value);
        $currency = $this->getCurrency();
        return $this->convertCurrency($newPrice, $currency);
    }

    public function getCurrencyAttribute()
    {
        $selectedCurrency = $this->getSelectedCurrency() ?? 'KWD';
        return __('website.' . $selectedCurrency);
    }

    private function calculateDiscountedPrice($value)
    {
        if ($this->category->bulk_discount_percentage == 0) {
            return $value > 0 ?  $value : 0;
        }

        if ($value == 0 && $this->category->bulk_discount_percentage > 0) {
            $discount = ($this->price * $this->brand->bulk_discount_percentage) / 100;
            return $this->price - $discount;
        }

        return  $value;
    }

    private function getCurrency()
    {
        return \Cache::has('currency') ? \Cache::get('currency') : Setting::first();
    }

    private function getSelectedCurrency()
    {
        $currency = request()->header('currency') ?? Session::get('currency');
        return $currency ?: null;
    }

    private function convertCurrency($price, $currency)
    {
        $selectedCurrency = $this->getSelectedCurrency();
        return match ($selectedCurrency) {
            'SAR' => $price * $currency->SAR,
            'BHD' => $price * $currency->BHD,
            'OMR' => $price * $currency->OMR,
            'QAR' => $price * $currency->QAR,
            'AED' => $price * $currency->AED,
            default => $price,
        };
    }


}
