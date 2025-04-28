<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model
{
    use SoftDeletes;

    protected $hidden = ['updated_at', 'deleted_at'];

    protected $guarded = [];

    protected $appends = ['status_name', 'payment_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class)->withTrashed();
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'address_id')->withTrashed();
    }

    public function country()
    {
        return $this->belongsTo(Country::class)->withTrashed();
    }

    public function city()
    {
        return $this->belongsTo(City::class)->withTrashed();
    }

    public function getStatusNameAttribute(): string
    {
        //	0->Placed , 1->On the Way , 2->Delivered , 3->Canceled
        return match ($this->status) {
            0 => __('website.placed'),
            1 => __('website.onWay'),
            2 => __('website.delivered'),
            3 => __('website.cancelled'),
            default => __('website.unknown_status'),
        };
    }

    public function getPaymentNameAttribute(): string
    {
        //	1->knet , 2->visa , 3->Mastercard ,4->Apple pay , 5->Samsung pay
        return match ($this->payment_method) {
            1 => __('website.KNET'),
            2 => __('website.Visa'),
            3 => __('website.Mastercard'),
            4 => __('website.Apple pay'),
            5 => __('website.Samsung pay'),
            default => __('website.unknown_method'),
        };
    }


    public function scopeFilter($query)
    {
        $filters = request()->only([
            'order_id', 'total', 'created_at', 'status', 'name',
            'start_date', 'end_date', 'email', 'mobile'
        ]);

        if (!empty($filters['order_id'])) {
            $query->where('id', $filters['order_id']);
        }

        if (!empty($filters['total'])) {
            $query->where('total', 'like', '%' . $filters['total'] . '%');
        }

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', 'like', '%' . $filters['created_at'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', Carbon::parse($filters['start_date']));
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', Carbon::parse($filters['end_date']));
        }

        if (!empty($filters['name'])) {
            $query->where(function ($query) use ($filters) {
                $query->whereHas('user', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['name'] . '%');
                })
                    ->orWhere('name', 'like', '%' . $filters['name'] . '%');
            });
        }
        if (!empty($filters['email'])) {
            $query->where(function ($query) use ($filters) {
                $query->whereHas('user', function ($query) use ($filters) {
                    $query->where('email', 'like', '%' . $filters['email'] . '%');
                })
                    ->orWhere('email', 'like', '%' . $filters['email'] . '%');
            });
        }
        if (!empty($filters['mobile'])) {
            $query->where(function ($query) use ($filters) {
                $query->whereHas('user', function ($query) use ($filters) {
                    $query->where('mobile', 'like', '%' . $filters['mobile'] . '%');
                })
                    ->orWhere('mobile', 'like', '%' . $filters['mobile'] . '%');
            });
        }
    }

}
