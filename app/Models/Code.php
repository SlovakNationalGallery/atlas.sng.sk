<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Code extends Model
{
    use HasFactory;
    use HasTranslations;

    const ROWS = 3;
    const COLS = 3;

    public $translatable = ['description', 'author_name', 'author_description'];

    protected $fillable = ['item_id'];

    // codes are stored in DB in decimal value, e.g. 000101010 -> 42
    public function getCodeAttribute($value)
    {
        return str_pad(decbin($value), self::ROWS * self::COLS, '0', STR_PAD_LEFT);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = bindec($value);
    }

    public static function randomCode()
    {
        $code = str_repeat('0', self::ROWS * self::COLS);
        $dots_count = rand(2, 3);
        for ($i = 0; $i < $dots_count; $i++) {
            $randomPos = rand(0, self::ROWS * self::COLS - 1);
            $code[$randomPos] = '1';
        }
        return $code;
    }

    public static function randomUniqueCode()
    {
        $code = self::randomCode();
        if (self::where('code', bindec($code))->exists()) {
            return self::randomUniqueCode();
        }
        return $code;
    }
}
