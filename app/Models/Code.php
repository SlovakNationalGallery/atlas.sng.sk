<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    const ROWS = 3;
    const COLS = 3;

    // codes are stored in DB in decimal value, e.g. 000101010 -> 42
    public function getCodeAttribute($value)
    {
        return str_pad(decbin($value), self::ROWS * self::COLS, '0', STR_PAD_LEFT);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = bindec($value);
    }
}
