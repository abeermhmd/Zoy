<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\WithFilters;

class Category extends Model
{
    use SoftDeletes, Translatable, WithFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['translations', 'updated_at', 'deleted_at'];

    /**
     * The translatable attributes.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'key_words'];

    /**
     * The fields that can be filtered with their configurations.
     *
     * @var array
     */
    protected $filterableFields = [
        'name' => ['operator' => 'like', 'method' => 'whereTranslationLike'],
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['active', 'not_active']],
        'is_featured' => ['operator' => '=', 'method' => 'where'],
        'department' => ['operator' => '=', 'method' => 'where', 'allowed' => ['man', 'women']],
        'id' => ['operator' => '=', 'method' => 'where'],
        'parent_id' => ['operator' => '=', 'method' => 'where'],
    ];

    /**
     * Get the image URL of the category.
     *
     * @param string|null $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === false) {
                return url('uploads/images/categories/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }

    /**
     * Get the subcategories of this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get the products associated with the category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Get the parent category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Scope a query to only include active categories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
