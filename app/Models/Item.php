<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasTranslations;

    public $incrementing = false;

    protected $translatable = ['description', 'author_name', 'author_description'];

    protected $attributes = [
        'offset_top' => 0,
    ];

    public function code()
    {
        return $this->morphOne(Code::class, 'codeable');
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
