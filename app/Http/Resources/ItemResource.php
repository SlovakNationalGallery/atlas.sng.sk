<?php

namespace App\Http\Resources;

use App\Models\Authority;
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
        $webumeniaAuthorities = collect($this['webumenia_item']->authorities);
        $authorities = Authority::whereIn('id', $webumeniaAuthorities->pluck('id'))
            ->get()
            ->keyBy('id')
            ->pipe(
                fn($authorities) => $webumeniaAuthorities->map(
                    fn($webumeniaAuthority) => [
                        'authority' => $authorities[$webumeniaAuthority->id] ?? null,
                        'webumenia_authority' => $webumeniaAuthority,
                    ]
                )
            );

        return [
            'id' => $this['webumenia_item']->id,
            'title' => $this['webumenia_item']->title,
            'author' => $this->getAuthor(),
            'dating' => $this['webumenia_item']->dating,
            'description' => $this->getDescription(),
            'authorities' => AuthorityResource::collection($authorities),
            'image_src' => $this->getImageRoute(),
            'image_srcset' => collect([220, 300, 600, 800])
                ->map(fn($width) => $this->getImageRoute($width) . " ${width}w")
                ->join(', '),
            'webumenia_url' => config('services.webumenia.url') . '/dielo/' . $this['webumenia_item']->id,
            'code' => $this['item']->code ? $this['item']->code->code : null,
            'offset_top' => $this['item']->offset_top,
            'video_thumbnail' => $this['item']->video_thumbnail,
            'video_embed' => $this['item']->video_embed,
            'video_aspect_ratio' => $this['item']->video_aspect_ratio,
        ];
    }

    private function getImageRoute($width = 600)
    {
        return config('services.webumenia.url') . '/dielo/nahlad/' . $this['webumenia_item']->id . '/' . $width;
    }

    private function getDescription()
    {
        if ($this['item']->description) {
            return str($this['item']->description)->markdown();
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
