<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = ['code'];

    public function bucketlist()
    {
        return $this->belongsTo(Bucketlist::class);
    }

    public static function generateCode()
    {
        $code = strtoupper(Str::random(6));
        if (self::where('code', $code)->exists()) {
            return self::generateCode();
        }
        return $code;
    }
}
