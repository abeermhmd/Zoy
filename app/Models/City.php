<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use App\Traits\WithFilters;

class City extends Model
{
    use SoftDeletes, Translatable, WithFilters;

    /**
     * The translatable attributes.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'deleted_at', 'translations'];

    /**
     * The fields that can be filtered with their configurations.
     *
     * @var array
     */
    protected $filterableFields = [
        'name' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['active', 'not_active']],
    ];

    /**
     * Scope a query to only include active cities.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
