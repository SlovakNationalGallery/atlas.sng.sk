<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Mtvs\EloquentHashids\HasHashid;

class Collection extends Model
{
    use HasFactory, HasHashid;

    protected $fillable = [
        'items',
    ];

    protected $casts = [
        'items' => AsCollection::class
    ];

}
