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
            'text' => str($this->text)->markdown(),
            'links' => StoryLinkResource::collection($this->links),
            'images' => ImageResource::collection(
                $this->getMedia()->filter(fn(Media $media) => $media->hasResponsiveImages())
            ),
            'video_thumbnail' => $this->video_thumbnail,
        ];
    }
}
