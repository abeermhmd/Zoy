<?php

namespace App\Models;

use App\Traits\WithFilters;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes, Notifiable, WithFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'mobile', 'status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at'
    ];

    /**
     * The fields that can be filtered with their configurations.
     *
     * @var array
     */
    protected $filterableFields = [
        'email' => ['operator' => 'like', 'method' => 'where'],
        'name' => ['operator' => 'like', 'method' => 'where'],
        'mobile' => ['operator' => 'like', 'method' => 'where'],
        'status' => ['operator' => '=', 'method' => 'where', 'allowed' => ['active', 'not_active']],
    ];

    /**
     * Get the user's image URL.
     *
     * @param string|null $value
     * @return string
     */
    public function getImageAttribute($value)
    {
        if ($value != null) {
            return url('uploads/images/users/' . $value);
        }
        return "";
    }

    /**
     * Get the user's permission.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne(UserPermission::class, 'user_id');
    }

    /**
     * Scope a query to only include active admins.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
