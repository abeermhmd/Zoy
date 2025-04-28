<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,SoftDeletes;

    protected $hidden = [
        'password', 'fcm_token' , 'updated_at', 'deleted_at'
    ];
    protected $dates = ['date_of_birth'];

    protected $guarded = [];

    protected $appends = ['order_count'];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function getOrderCountAttribute(): string
    {
        return Order::where('user_id' , $this->id)->where('payment_status' , 1)->count();
    }
    public function scopeFilter($query)
    {
        $query->when(request()->has('name') && request()->get('name') != null  , function($q){
            $q->where('name', 'like', '%' . request()->get('name') . '%');
        });

        $query->when(request()->has('email') && request()->get('email') != null  , function($q){
            $q->where('email', 'like', '%' . request()->get('email') . '%');
        });

        $query->when(request()->has('mobile') && request()->get('mobile') != null  , function($q){
            $q->where('mobile', 'like', '%' . request()->get('mobile') . '%');
        });

        $query->when(request()->has('status') && request()->get('status') != null  , function($q){
            $q->where('status', request()->get('status'));
        });

        $query->when(request()->has('id') && request()->get('id') != null , function($q){
            $q->where('id', request()->get('id'));
        });
    }

}
