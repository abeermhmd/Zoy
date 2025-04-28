<?php
namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes, Translatable;
    protected $guarded = [];
    public $translatedAttributes = ['name'];
    
    public function scopeFilter($query)
    {
        $query->when(request()->has('name') && request()->get('name') != null, function ($q) {
            $q->whereTranslationLike('name', '%' . request()->get('name') . '%');
        });
    }
}

