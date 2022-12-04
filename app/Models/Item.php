<?php

namespace App\Models;

use App\Models\Concerns\HasCode;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasCode, HasTranslations;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['description', 'author_name', 'author_description'];

    protected $attributes = [
        'offset_top' => 0,
    ];

    public function getVideoAttribute()
    {
        return ($this->attributes['video']) ? getVimeoVideoIdFromUrl($this->attributes['video']) : null;
    }
}
