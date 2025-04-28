<?php



namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailText extends Model
{
    use SoftDeletes, Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['subject','content'];
    protected $appends = ['type_name'];

    public function getTypeNameAttribute(): string
    {
        return match ($this->type) {
            'abandoned_cart' => __('cp.abandoned_cart'),
            'continue_order' => __('cp.continue_order'),
            'Order_status_updated' => __('cp.Order_status_updated'),
            'Uncompleted_orders' => __('cp.Uncompleted_orders'),
            'Birthday' => __('cp.Birthday'),
            'After_Registration' => __('cp.After_Registration'),
            default => __('website.unknown_status'),
        };
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

}

