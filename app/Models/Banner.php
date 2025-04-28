<?php

namespace App\Models;

use App\Traits\WithFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use SoftDeletes, WithFilters;

    protected $guarded = [];

    protected $hidden = ['updated_at', 'deleted_at'];

    protected $filterableFields = [
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['active', 'not_active']],
        'type_link' => ['operator' => '=', 'method' => 'where'],
        'type' => ['operator' => '=', 'method' => 'where'],
    ];

    /**
     * Get the banner's image URL.
     *
     * @param string|null $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                return url('uploads/images/mainImages/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }

    /**
     * Get the category associated with the banner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'linked_id');
    }

    /**
     * Get the subcategory associated with the banner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'linked_id');
    }

    /**
     * Get the product associated with the banner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'linked_id');
    }

    /**
     * Scope a query to only include active banners.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
