<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exhibition extends Model
{
    public $incrementing = false;

    public function codes()
    {
        return $this->hasMany(Code::class);
    }
}
