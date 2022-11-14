<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Story extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    public $incrementing = false;

    protected $keyType = 'string';

    protected array $translatable = ['text'];

    public function links()
    {
        return $this->belongsToMany(StoryLink::class)->orderByPivot('ord');
    }
}
