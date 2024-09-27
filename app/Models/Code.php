<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    const ROWS = 3;
    const COLS = 3;

    public function codeable()
    {
        return $this->morphTo();
    }

    public function exhibition()
    {
        return $this->belongsTo(Exhibition::class);
    }

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
        $dots_count = rand(config('atlas.min_dots'), config('atlas.max_dots'));

        $positions = [];

        while (count($positions) < $dots_count) {
            $randomPos = rand(0, self::ROWS * self::COLS - 1);

            // Ensure the position hasn't been selected before
            if (!in_array($randomPos, $positions)) {
                $code[$randomPos] = '1';
                $positions[] = $randomPos;
            }
        }

        return $code;
    }

    public static function randomUniqueCode($attempts = 1000)
    {
        while ($attempts > 0) {
            $code = self::randomCode();
            if (!self::where('code', bindec($code))->exists()) {
                return $code;
            }
            $attempts--;
        }

        throw new \Exception('Failed to generate a unique code within the allowed attempts.');
    }

    protected static function booted()
    {
        static::creating(function (self $code) {
            $code->code = Code::randomUniqueCode();
        });
    }

    public static function calculateTotalPossibleCodes()
    {
        $totalPositions = self::ROWS * self::COLS;

        return collect(range(config('atlas.min_dots'), config('atlas.max_dots')))
            ->sum(fn($dots) => gmp_intval(gmp_binomial($totalPositions, $dots)));
    }
}
