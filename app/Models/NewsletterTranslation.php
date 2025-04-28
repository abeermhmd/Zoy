<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewsletterTranslation extends Model
{
    use SoftDeletes;
    protected $fillable = ['subject','content','locale'];
}
