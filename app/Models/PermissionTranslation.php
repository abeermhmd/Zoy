<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionTranslation extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','permission_id','locale'];
    
}
