<?php

namespace App\Http\Resources;

use App\Video\VimeoApi;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PlaceResource extends JsonResource
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
            'code' => $this->code ? $this->code->code : null,
            'title' => $this->title,
            'description' => str($this->description)->markdownWithLineBreaks(),
            'image' => new ImageResource($this->getFirstMedia()),
            'video_thumbnail' => $this->video_thumbnail,
            'video_duration' => $this->video_duration ? gmdate('i:s', $this->video_duration) : null,
            'video_embed' => $this->video_embed,
            'video_aspect_ratio' => $this->video_aspect_ratio,
            'story_id' => $this->story_id,
        ];
    }
}
