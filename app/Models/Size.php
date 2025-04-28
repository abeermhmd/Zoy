<?php

namespace App\Models;

use App\Traits\WithFilters;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Size
 *
 * Represents a Size entity in the application, supporting translations and soft deletes.
 */
class Size extends Model
{
    // Use traits for reusable functionality
    use SoftDeletes, Translatable, WithFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays or JSON serialization.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
        'deleted_at',
        'translations',
    ];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name'];

    /**
     * The fields available for filtering with the WithFilters trait.
     *
     * @var array
     */
    protected $filterableFields = [
        'status' => [
            'operator' => '=','method' => 'where','allowed' => ['active', 'not_active']],
        'name' => ['operator' => 'like','method' => 'whereTranslationLike'],
    ];

    /**
     * Scope to filter active sizes.
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
