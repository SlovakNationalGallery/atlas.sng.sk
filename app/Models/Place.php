<?php

namespace App\Models;

use App\Models\Concerns\HasCode;
use App\Traits\HasVideo;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Place extends Model implements HasMedia
{
    use HasCode, HasTranslations, HasVideo, InteractsWithMedia;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = [
        'title',
        'description',
        'video',
        'video_title',
        'video_subtitle',
    ];

    protected $attributes = [
        'offset_top' => 0,
    ];
}
