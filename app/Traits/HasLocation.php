<?php

namespace App\Traits;

use App\Models\Location;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasLocation
{
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
