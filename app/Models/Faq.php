<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Astrotomic\Translatable\Translatable;
use App\Traits\WithFilters;

class Faq extends Model
{
    use SoftDeletes, Translatable, WithFilters;

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['question', 'answer'];

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
        'question' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
        'answer' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
    ];

    /**
     * Scope a query to only include active records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
