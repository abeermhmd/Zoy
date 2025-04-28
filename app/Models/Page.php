<?php
namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes, Translatable;

    public $translatedAttributes = ['name', 'description', 'key_words'];
    protected $hidden = ['updated_at', 'deleted_at','translations'];
    protected $fillable = ['image'];

    public function getImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
                return url('uploads/images/pages/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }

}

