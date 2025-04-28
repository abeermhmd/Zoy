<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model
{
    protected $fillable = ['locale', 'setting_id', 'title','shipping_content_kuwait','shipping_content_outside_kuwait'
            ,'instagram_text_footer' , 'key_words'];
}
