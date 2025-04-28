<?php

namespace App\Models;

use App\Traits\WithFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscriber
 *
 * Represents a Subscriber entity in the application, supporting soft deletes and filtering.
 */
class Subscriber extends Model
{
    use SoftDeletes, WithFilters;
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays or JSON serialization.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
    ];

    /**
     * The fields available for filtering with the WithFilters trait.
     *
     * @var array
     */
    protected $filterableFields = [
        'email' => [ 'operator' => 'like', 'method' => 'where','field' => 'email' ],
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['active', 'not_active']],

    ];

    /**
     * Scope to filter active subscribers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
