<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductImage extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
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
