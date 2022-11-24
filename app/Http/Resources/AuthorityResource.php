<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AuthorityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this['webumenia_authority']->id,
            'name' => $this->getName(),
            'has_image' => $this['webumenia_authority']->has_image,
            'biography' => $this->getBiography(),
            'birth_place' => $this['webumenia_authority']->birth_place,
            'death_place' => $this['webumenia_authority']->death_place,
            'birth_date' => $this['webumenia_authority']->birth_date,
            'death_date' => $this['webumenia_authority']->death_date,
            'image_url' => $this->getImageUrl($this['webumenia_authority']->image_path),
        ];
    }

    protected function getName(): string
    {
        return $this['authority']->name ?? formatName($this['webumenia_authority']->name);
    }

    protected function getBiography(): ?string
    {
        return $this['authority']->biography ??
            $this->formatWebumeniaBiography($this['webumenia_authority']->biography);
    }

    protected function formatWebumeniaBiography(?string $biography): ?string
    {
        if (null === $biography) {
            return null;
        }

        $biography = strip_tags($biography);
        $biography = html_entity_decode($biography);
        return Str::of($biography)
            ->replace("\u{00a0}", ' ')
            ->replaceMatches('/\s*\n+\s*/', "\n\n")
            ->trim();
    }

    protected function getImageUrl(string $imagePath): string
    {
        return sprintf('%s%s', config('services.webumenia.url'), $imagePath);
    }
}
