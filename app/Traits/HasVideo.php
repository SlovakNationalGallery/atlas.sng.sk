<?php

namespace App\Traits;
use App\Video\VimeoApi;
use Illuminate\Support\Str;

trait HasVideo
{
    public function getVideoIdAttribute()
    {
        return $this->video
            ? (int) Str::remove('https://vimeo.com/', $this->video)
            : null;
    }

    public function getVideoThumbnailAttribute()
    {
        if (!$this->video) {
            return null;
        }
        $video = app(VimeoApi::class)->getVideo($this->video_id);
        $sizes = collect($video['pictures']->sizes);
        $largest = $sizes->last();
        return [
            'src' => Str::remove('?r=pad', $largest->link),
            'srcset' => $sizes
                ->map(
                    fn($size) => sprintf(
                        '%s %sw',
                        Str::remove('?r=pad', $size->link),
                        $size->width
                    )
                )
                ->join(', '),
            'width' => $largest->width,
            'height' => $largest->height,
        ];
    }

    public function getVideoAspectRatioAttribute()
    {
        if (!$this->video) {
            return null;
        }
        $video = app(VimeoApi::class)->getVideo($this->video_id);
        $divisor = gmp_intval(gmp_gcd($video['width'], $video['height']));
        return collect([
            'width' => $video['width'] / $divisor,
            'height' => $video['height'] / $divisor,
        ]);
    }

    public function getVideoEmbedAttribute()
    {
        if (!$this->video) {
            return null;
        }
        $video = app(VimeoApi::class)->getVideo($this->video_id);
        return $video['player_embed_url'];
    }

    public function getVideoDurationAttribute()
    {
        if (!$this->video) {
            return null;
        }
        $video = app(VimeoApi::class)->getVideo($this->video_id);
        return $video['duration'];
    }
}
