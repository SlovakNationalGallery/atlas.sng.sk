<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasTranslations;

    public $incrementing = false;

    protected $translatable = ['title', 'description'];

    public function code()
    {
        return $this->morphOne(Code::class, 'codeable');
    }

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    protected static function booted()
    {
        static::created(function (self $item) {
            $item->code()->create();
        });

        static::deleting(function (self $item) {
            $item->code()->delete();
        });
    }
}
