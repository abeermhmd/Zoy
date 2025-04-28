<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTextTranslation extends Model
{
    use SoftDeletes;
    protected $fillable = ['subject','content','locale'];
}
