<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqTranslation extends Model
{
    use SoftDeletes;

    protected $fillable = ['locale', 'faq_id', 'question', 'answer'];
}

