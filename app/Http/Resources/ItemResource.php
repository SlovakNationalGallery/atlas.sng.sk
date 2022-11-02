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
            'code' => $this->code->code,
            'offset_top' => $this->code->offset_top,
            'author_description' => $this->code->author_description,
        ];
    }

    private function getImageRoute($width = 600)
    {
        return config('services.webumenia.url') . '/dielo/nahlad/' . $this->id . '/' . $width;
    }

    private function getDescription()
    {
        if ($this->code->description) {
            return nl2br($this->code->description);
        }

        return $this->description;
    }

    private function getAuthor()
    {
        if ($this->code->author_name) {
            return $this->code->author_name;
        }

        return collect($this->authors)
            ->map(fn(string $author) => formatName($author))
            ->join(', ');
    }
}
