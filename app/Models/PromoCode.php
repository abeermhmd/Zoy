<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    protected $hidden = ['updated_at', 'deleted_at'];
    protected $dates = ['end_date', 'start_date'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function promoCodeCountries(){
        return $this->hasMany(PromoCodeCountry::class);
    }
    public function scopeFilter($query)
    {
        if (request()->has('code')) {
            if (request()->get('code') != null)
                $query->where('code', 'like', '%' . request()->get('code') . '%');
        }
        if (request()->has('percent')) {
            if (request()->get('percent') != null)
                $query->where('percent', 'like', '%' . request()->get('percent') . '%');
        }

        if (request()->has('number_remaining_uses')) {
            if (request()->get('number_remaining_uses') != null)
                $query->where('number_remaining_uses', request()->get('number_remaining_uses') );
        }
        if (request()->get('start_date') && request()->get('end_date')) {
            $query->whereDate('start_date', '>=', Carbon::parse(request()->get('start_date')));
            $query->whereDate('end_date', '<=', Carbon::parse(request()->get('end_date')));
        }
        if (request()->get('start_date')) {
            if (request()->get('start_date') != null)
                $query->whereDate('start_date', '>=', Carbon::parse(request()->get('start_date')));
        }
        if (request()->get('end_date')) {
            if (request()->get('end_date') != null)
                $query->whereDate('end_date', '<=', Carbon::parse(request()->get('end_date')));
        }
        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }
        if (request()->has('id')) {
            if (request()->get('id') != null)
                $query->where('id', request()->get('id'));
        }


    }
}
