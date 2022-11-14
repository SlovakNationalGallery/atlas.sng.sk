<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Authority extends Model
{
    use HasTranslations;

    public $incrementing = false;

    protected $translatable = ['biography'];
}
