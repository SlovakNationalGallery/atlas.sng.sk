<?php

namespace App\Http\Resources;

use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
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
            'id' => $this['section']->id,
            'title' => $this['section']->title,
            'description' => $this['section']->description,
            'code' => $this['section']->code->code,
            'items' => ItemResource::collection($this->items()),
        ];
    }

    protected function items()
    {
        return $this['section']->items->map(
            fn(Item $item) => [
                'item' => $item,
                'webumenia_item' => $this['webumenia_items'][$item->id],
            ]
        );
    }
}
