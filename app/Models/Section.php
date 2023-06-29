<?php

namespace App\Models;

use App\Models\Concerns\HasCode;
use App\Traits\HasLocation;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Section extends Model implements HasMedia
{
    use HasCode, HasTranslations, HasLocation, InteractsWithMedia;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['title', 'description'];

    protected $fillable = [
        'id',
        'title',
        'description',
        'location_id',
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class)->orderByPivot('ord');
    }
}
