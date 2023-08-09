<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class BucketlistResource extends JsonResource
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
            'id' => $this['bucketlist']->id,
            'title' => $this['bucketlist']->title,
            'text' => str($this['bucketlist']->text)->markdownWithLineBreaks(),
            'image' => new ImageResource($this['bucketlist']->getFirstMedia()),
            'items' => ItemResource::collection(
                $this->when($this['bucketlist']->relationLoaded('items'), fn() => $this->items())
            ),
        ];
    }

    protected function items()
    {
        return $this['bucketlist']->items->map(
            fn(Item $item) => [
                'item' => $item,
                'webumenia_item' => $this['webumenia_items'][$item->id],
            ]
        );
    }
}
