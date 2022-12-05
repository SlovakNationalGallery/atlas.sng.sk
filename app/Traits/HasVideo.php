<?php

namespace App\Traits;
use App\Video\VimeoApi;

trait HasVideo
{
    public function initializeHasVideo()
    {
        $this->append('video_id', 'video_thumbnail');
    }

    public function getVideoIdAttribute()
    {
        return $this->video ? $this->getVimeoVideoIdFromUrl($this->video) : null;
    }

    public function getVideoThumbnailAttribute()
    {
        if (!$this->video) {
            return null;
        }
        $thumbnail = app(VimeoApi::class)->getThumbnail($this->video_id);
        $sizes = collect($thumbnail->sizes);
        $largest = $sizes->last();
        return [
            'src' => $largest->link,
            'srcset' => $sizes->map(fn($size) => sprintf('%s %sw', $size->link, $size->width))->join(', '),
            'width' => $largest->width,
            'height' => $largest->height,
        ];
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
