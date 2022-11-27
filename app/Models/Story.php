<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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

    protected function getTextAttribute($value)
    {
        return Str::of($value)
            ->replaceMatches('/\*\*(\s*)(.*?)(\s*)\*\*/', '$1**$2**$3')
            ->replaceMatches('/_(\s*)(.*?)(\s*)_/', '$1_$2_$3')
            ->replaceMatches('/~~(\s*)(.*?)(\s*)~~/', '$1~~$2~~$3');
    }
}
