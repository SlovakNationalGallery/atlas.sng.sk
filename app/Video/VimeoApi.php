<?php

namespace App\Video;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VimeoApi
{
    public function getThumbnail($videoId)
    {
        return Cache::remember(
            sprintf('vimeo_thumbnail.%s', $videoId),
            now()->addHour(),
            fn() => collect(
                Http::vimeo()
                    ->get("/videos/$videoId/pictures")
                    ->object()->data
            )->first(fn($thumbnail) => $thumbnail->active)
        );
    }
}
