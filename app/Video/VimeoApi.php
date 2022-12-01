<?php

namespace App\Video;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VimeoApi
{
    public function getThumbnail($videoId)
    {
        $response = Http::vimeo()
            ->get("/videos/$videoId/pictures")
            ->object();

        if (isset($response->error)) {
            throw new \Exception($response->error);
        }

        return Cache::remember(
            sprintf('vimeo_thumbnail.%s', $videoId),
            now()->addHour(),
            fn() => collect($response->data)->first(fn($thumbnail) => $thumbnail->active)
        );
    }
}
