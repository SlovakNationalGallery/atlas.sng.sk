<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Bucketlist extends Model
{
    use HasFactory, HasTranslations;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['title'];

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class)->orderByPivot('ord');
    }
}
