<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCodeCountry extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}

