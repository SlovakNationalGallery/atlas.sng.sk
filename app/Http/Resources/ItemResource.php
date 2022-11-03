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
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->getAuthor(),
            'dating' => $this->dating,
            'description' => $this->getDescription(),
            'authorities' => AuthorityResource::collection($this->authorities),
            'image_src' => $this->getImageRoute(),
            'image_srcset' => collect([220, 300, 600, 800])
                ->map(fn($width) => $this->getImageRoute($width) . " ${width}w")
                ->join(', '),
            'webumenia_url' => config('services.webumenia.url') . '/dielo/' . $this->id,
            'code' => $this->item->code?->code,
            'offset_top' => $this->item->offset_top,
            'author_description' => $this->item->author_description,
        ];
    }

    private function getImageRoute($width = 600)
    {
        return config('services.webumenia.url') . '/dielo/nahlad/' . $this->id . '/' . $width;
    }

    private function getDescription()
    {
        if ($this->item->description) {
            return nl2br($this->item->description);
        }

        return $this->description;
    }

    private function getAuthor()
    {
        if ($this->item->author_name) {
            return $this->item->author_name;
        }

        return collect($this->authors)
            ->map(fn(string $author) => formatName($author))
            ->join(', ');
    }
}
