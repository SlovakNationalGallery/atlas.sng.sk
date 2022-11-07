<?php

namespace App\Models\Concerns;

use App\Models\Code;

trait HasCode
{
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
