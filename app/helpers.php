<?php

function formatName($name)
{
    return preg_replace('/^([^,]*),\s*(.*)$/', '$2 $1', $name);
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

function getVimeoVideoIdFromUrl($url = '')
{

    $regs = [];
    $id = '';

    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
        $id = $regs[3];
    }

    return $id;
}