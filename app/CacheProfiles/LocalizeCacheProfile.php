<?php

namespace App\CacheProfiles;

use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests;
use Illuminate\Http\Request;

class LocalizeCacheProfile extends CacheAllSuccessfulGetRequests
{
    public function useCacheNameSuffix(Request $request): string
    {
        return $request->header('X-locale', app()->getLocale());
    }
}
