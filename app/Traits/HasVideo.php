<?php

namespace App\Traits;
use App\Video\VimeoApi;

trait HasVideo
{
    public function getVideoThumbnailAttribute()
    {
        if (!$this->video) {
            return null;
        }
        $video = app(VimeoApi::class)->getVideo($this->video_id);
        $sizes = collect($video['pictures']->sizes);
        $largest = $sizes->last();
        return [
            'src' => $largest->link,
            'srcset' => $sizes->map(fn($size) => sprintf('%s %sw', $size->link, $size->width))->join(', '),
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

    /**
     * Get Vimeo video id from url
     *
     * Supported url formats -
     *
     * https://vimeo.com/11111111
     * http://vimeo.com/11111111
     * https://www.vimeo.com/11111111
     * http://www.vimeo.com/11111111
     * https://vimeo.com/channels/11111111
     * http://vimeo.com/channels/11111111
     * https://vimeo.com/groups/name/videos/11111111
     * http://vimeo.com/groups/name/videos/11111111
     * https://vimeo.com/album/2222222/video/11111111
     * http://vimeo.com/album/2222222/video/11111111
     * https://vimeo.com/11111111?param=test
     * http://vimeo.com/11111111?param=test
     *
     * @param string $url The URL
     *
     * @return string the video id extracted from url
     */

    private function getVimeoVideoIdFromUrl($url = '')
    {
        $regs = [];
        $id = '';

        if (
            preg_match(
                '%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im',
                $url,
                $regs
            )
        ) {
            $id = $regs[3];
        }

        return $id;
    }
}
