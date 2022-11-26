<?php

namespace App\Http\Resources;

use App\Video\VimeoApi;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class StoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'links' => StoryLinkResource::collection($this->links),
            'images' => ImageResource::collection(
                $this->getMedia()->filter(fn(Media $media) => $media->hasResponsiveImages())
            ),
            'video_thumbnail' => $this->when($this->video, fn() => $this->getVideoThumbnail()),
        ];
    }

    protected function getVideoThumbnail()
    {
        $thumbnail = app(VimeoApi::class)->getThumbnail($this->video);
        $sizes = collect($thumbnail->sizes);
        $largest = $sizes->last();
        return [
            'src' => $largest->link,
            'srcset' => $sizes->map(fn($size) => sprintf('%s %sw', $size->link, $size->width))->join(', '),
            'width' => $largest->width,
            'height' => $largest->height,
        ];
    }
}
