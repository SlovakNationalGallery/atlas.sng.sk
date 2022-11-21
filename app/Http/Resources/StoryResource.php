<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
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
            'text' => $this->text(),
            'links' => StoryLinkResource::collection($this->links),
            'images' => ImageResource::collection(
                $this->getMedia()->filter(fn(Media $media) => $media->hasResponsiveImages())
            ),
        ];
    }

    protected function text()
    {
        return Str::of($this->text)
            ->replaceMatches('/\*\*(\s*)(.*?)(\s*)\*\*/', '$1**$2**$3')
            ->replaceMatches('/_(\s*)(.*?)(\s*)_/', '$1_$2_$3')
            ->replaceMatches('/~~(\s*)(.*?)(\s*)~~/', '$1~~$2~~$3');
    }
}
