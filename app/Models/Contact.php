<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\WithFilters;

class Contact extends Model
{
    use SoftDeletes, WithFilters;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'message', 'mobile'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at'];

    /**
     * The fields that can be filtered with their configurations.
     *
     * @var array
     */
    protected $filterableFields = [
        'name' => ['operator' => 'like', 'method' => 'where'],
        'email' => ['operator' => 'like', 'method' => 'where'],
        'mobile' => ['operator' => 'like', 'method' => 'where'],
        'status' => ['operator' => '=', 'method' => 'where', 'field' => 'read'],
    ];
}
