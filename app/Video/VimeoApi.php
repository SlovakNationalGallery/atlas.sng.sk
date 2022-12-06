<?php

namespace App\Video;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VimeoApi
{
    public function getVideo($videoId)
    {
        return Cache::remember(sprintf('vimeo_video.%s', $videoId), now()->addHour(), function () use ($videoId) {
            $response = Http::vimeo()
                ->get("/videos/$videoId/")
                ->object();

            if (isset($response->error)) {
                throw new \Exception($response->error);
            }
            return collect([
                'player_embed_url' => $response->player_embed_url,
                'duration' => $response->duration,
                'width' => $response->width,
                'height' => $response->height,
                'pictures' => $response->pictures,
            ]);
        });
    }
}
