<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Story extends Model
{
    use HasTranslations;

    protected array $translatable = ['text'];

    public function links()
    {
        return $this->belongsToMany(StoryLink::class);
    }
}
