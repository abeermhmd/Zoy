<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotifyProduct extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['updated_at', 'deleted_at'];

    public function scopeFilter($query)
    {
        if (request()->has('email')) {
            if (request()->get('email') != null)
                $query->where('email', request()->get('email'));
        }
    }

}
