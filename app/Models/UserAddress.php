<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['deleted_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function scopeFilter($query)
    {
        if (request()->has('title')) {
            if (request()->get('title') != null)
                $query->where(function ($q) {$q->where('title', 'like', '%' . request()->get('title') . '%');});
        }
    }
}

