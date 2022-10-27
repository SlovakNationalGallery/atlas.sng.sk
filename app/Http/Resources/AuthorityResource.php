<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AuthorityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'has_image' => $this->has_image,
            'biography' => $this->formatBiography($this->biography),
            'birth_place' => $this->birth_place,
            'death_place' => $this->death_place,
            'birth_date' => $this->birth_date,
            'death_date' => $this->death_date,
            'image_url' => $this->getImageUrl($this->image_path),
        ];
    }

    public function formatBiography(?string $biography): ?string
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

    public function getImageUrl(string $imagePath): string
    {
        return sprintf('%s%s', config('services.webumenia.url'), $imagePath);
    }
}
