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
            'author' => collect($this->author)->map(function ($name) {
                return preg_replace('/^([^,]*),\s*(.*)$/', '$2 $1', $name);
            })->join(', '),
            'dating' => $this->dating,
            'description' => $this->description,
            'image_src' => $this->getImageRoute(),
            'image_srcset' => collect([220, 300, 600, 800])
                ->map(fn ($width) => $this->getImageRoute($width) . " ${width}w")
                ->join(', '),
            'webumenia_url' => config('services.webumenia.url') . '/dielo/' . $this->id
        ];
    }

    private function getImageRoute($width=600)
    {
        return config('services.webumenia.url') . '/dielo/nahlad/' . $this->id . '/' . $width;
    }


}
