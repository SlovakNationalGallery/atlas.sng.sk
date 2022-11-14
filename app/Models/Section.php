<?php

namespace App\Models;

use App\Models\Concerns\HasCode;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasCode, HasTranslations;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $translatable = ['title', 'description'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
