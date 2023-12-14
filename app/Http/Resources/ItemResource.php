<?php

namespace App\Http\Resources;

use App\Models\Authority;
use App\Models\Bucketlist;
use Illuminate\Support\Str;
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
            'author_description' => $this['item']->author_description,
            'dating' => $this->getDating(),
            'locked_bucketlist_description' => str(
                $this['item']->locked_bucketlist_description
            )->markdownWithLineBreaks(),
            'dating_short' => $this->getDatingShort(),
            'description' => $this->getDescription(),
            'authorities' => AuthorityResource::collection($authorities),
            'image_src' => $this->getImageRoute(),
            'image_srcset' => collect([220, 300, 600, 800])
                ->map(fn($width) => $this->getImageRoute($width) . " ${width}w")
                ->join(', '),
            'images' => $this['webumenia_item']->images,
            'image_aspect_ratio' => $this['webumenia_item']->image_ratio,
            'webumenia_url' => config('services.webumenia.url') . '/dielo/' . $this['webumenia_item']->id,
            'code' => $this['item']->code ? $this['item']->code->code : null,
            'offset_top' => $this['item']->offset_top,
            'offset_top_percentage' => $this->calculateOffsetTopPercentage(
                $this['item']->offset_top,
                $this['webumenia_item']->image_ratio
            ),
            'video_thumbnail' => $this['item']->video_thumbnail,
            'video_embed' => $this['item']->video_embed,
            'video_aspect_ratio' => $this['item']->video_aspect_ratio,
            'video_title' => $this['item']->video_title,
            'video_subtitle' => $this['item']->video_subtitle,
            'story_id' => $this['item']->story_id,
            'location_formatted' => $this['item']->location?->__toString(),
            'exhibition' => new ExhibitionResource($this['item']->code->exhibition ?? null),
            'bucketlists' => BucketlistResource::collection(
                $this['item']->bucketlists->map(fn(Bucketlist $bucketlist) => ['bucketlist' => $bucketlist])
            ),
        ];
    }

    private function getImageRoute($width = 600)
    {
        return config('services.webumenia.url') . '/dielo/nahlad/' . $this['webumenia_item']->id . '/' . $width;
    }

    private function getDescription()
    {
        if ($this['item']->description) {
            return str($this['item']->description)->markdownWithLineBreaks();
        }

        return $this['webumenia_item']->description;
    }

    private function getDatingRaw()
    {
        return $this['webumenia_item']->date_earliest === $this['webumenia_item']->date_latest
            ? $this['webumenia_item']->date_earliest
            : $this['webumenia_item']->date_earliest . '–' . $this['webumenia_item']->date_latest;
    }

    private function getDating()
    {
        if (\App::currentLocale() == 'sk') {
            return $this['webumenia_item']->dating;
        }

        return $this->getDatingRaw();
    }

    private function getDatingShort()
    {
        if (\App::currentLocale() == 'sk') {
            return Str($this['webumenia_item']->dating)
                ->afterLast(',')
                ->squish();
        }

        return $this->getDatingRaw();
    }
    private function getAuthor()
    {
        $localAuthoritiesNames = explode(', ', $this['item']->author_name);
        $webumeniaAuthorities = collect($this['webumenia_item']->authorities);
        $webumeniaAuthoritiesNames = $webumeniaAuthorities->map(fn(object $authority) => formatName($authority->name));

        $filteredLocalAuthoritiesNames = collect($localAuthoritiesNames)->reject(
            fn($name) => $webumeniaAuthoritiesNames->contains(formatName($name))
        )->filter();

        $webumeniaAuthoritiesRoles = $webumeniaAuthorities->map(
            fn(object $authority) => formatName($authority->name) .
                (!empty($authority->role) && !in_array($authority->role, ['autor', 'author'])
                    ? ' - ' . $authority->role
                    : '')
        );

        return $webumeniaAuthoritiesRoles->concat($filteredLocalAuthoritiesNames)->join(', ');
    }

    function calculateOffsetTopPercentage($offset_top, $aspect_ratio)
    {
        if (!$offset_top || !$aspect_ratio) {
            return 0;
        }
        $height = 512 / $aspect_ratio;
        $percentage = -1 * $offset_top / $height * 100; // because of we need positive number for percentage
        return round($percentage, 2);
    }
}
