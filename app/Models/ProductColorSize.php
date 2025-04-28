<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColorSize extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->hasMany(ProductColorImage::class, 'product_color_size_id');
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
}
