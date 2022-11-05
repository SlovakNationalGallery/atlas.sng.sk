<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'id' => $this['webumenia_item']->id,
            'title' => $this['webumenia_item']->title,
            'author' => $this->getAuthor(),
            'dating' => $this['webumenia_item']->dating,
            'description' => $this->getDescription(),
            'authorities' => AuthorityResource::collection($this['webumenia_item']->authorities),
            'image_src' => $this->getImageRoute(),
            'image_srcset' => collect([220, 300, 600, 800])
                ->map(fn($width) => $this->getImageRoute($width) . " ${width}w")
                ->join(', '),
            'webumenia_url' => config('services.webumenia.url') . '/dielo/' . $this['webumenia_item']->id,
            'code' => $this['item']->code?->code,
            'offset_top' => $this['item']->offset_top,
            'author_description' => $this['item']->author_description,
        ];
    }

    private function getImageRoute($width = 600)
    {
        return config('services.webumenia.url') . '/dielo/nahlad/' . $this['webumenia_item']->id . '/' . $width;
    }

    private function getDescription()
    {
        if ($this['item']->description) {
            return nl2br($this['item']->description);
        }

        return $this['webumenia_item']->description;
    }

    private function getAuthor()
    {
        if ($this['item']->author_name) {
            return $this['item']->author_name;
        }

        return collect($this['webumenia_item']->authors)
            ->map(fn(string $author) => formatName($author))
            ->join(', ');
    }
}
