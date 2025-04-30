<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Translatable;
    public $translatedAttributes = ['title' ,'shipping_content_kuwait','shipping_content_outside_kuwait','instagram_text_footer', 'key_words'
            ,'area', 'block', 'address','street'];
    public $guarded = [];
    protected $hidden = ['translations'];

    public function getLogoAttribute($logo)
    {
        return !is_null($logo) && file_exists(public_path('uploads/images/settings/'.$logo))
        ? url('uploads/images/settings/'.$logo): admin_assets('images/testLogo.svg');
    }

    public function getImageAttribute($image)
    {
         return !is_null($image) && file_exists(public_path('uploads/images/settings/'.$image))
         ? url('uploads/images/settings/'.$image): admin_assets('images/login.svg');
    }

    public function getBannerAdImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
                return url('uploads/images/settings/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }

    public function getAdPopUpImageAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
                return url('uploads/images/settings/' . $value);
            } else {
                return $value;
            }
        } else {
            return admin_assets('images/ChoosePhoto.png');
        }
    }


}
