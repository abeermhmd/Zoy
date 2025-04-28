<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use App\Traits\WithFilters;

class Country extends Model
{
    use SoftDeletes, Translatable, WithFilters;

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
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['active', 'not_active']],
        'name' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * Scope a query to only include active countries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the cities for the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
