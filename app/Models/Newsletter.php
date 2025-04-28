<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\WithFilters;

class Newsletter extends Model
{
    use SoftDeletes, Translatable, WithFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['subject', 'content'];

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
        'subject' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['scheduled', 'delivered', 'draft']],
    ];

    /**
     * Scope a query to only include active newsletters.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
