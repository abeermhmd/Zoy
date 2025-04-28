<?php



namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManualEmailUser extends Model

{
    use SoftDeletes;

    protected $guarded = [];
    protected $hidden = ['updated_at', 'deleted_at'];


    public function scopeFilter($query)
    {
        if (request()->has('subject')) {
            if (request()->get('subject') != null)
                $query->where(function ($q) {
                    $q->whereTranslationLike('subject', '%' . request()->get('subject') . '%');
                });
        }
        if (request()->has('status')) {
            if (request()->get('status') != null)
                $query->where('status', request()->get('status'));
        }
    }
}

