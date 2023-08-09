<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Bucketlist extends Model implements HasMedia
{
    use HasFactory, HasTranslations, InteractsWithMedia;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['title', 'text'];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->orderByPivot('ord');
    }
}
