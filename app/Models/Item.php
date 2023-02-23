<?php

namespace App\Models;

use App\Models\Concerns\HasCode;
use App\Traits\HasLocation;
use App\Traits\HasVideo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasCode, HasTranslations, HasVideo, HasLocation;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['description', 'author_name', 'author_description', 'video_title', 'video_subtitle'];

    protected $attributes = [
        'offset_top' => 0,
    ];
}
