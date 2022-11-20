<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StoryLink extends Model
{
    use HasTranslations;

    public $incrementing = false;

    protected $keyType = 'string';

    protected array $translatable = ['title'];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}
