<?php

namespace App\Traits;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait SyncsMedia
{
    protected static function syncMedia(Model $model, Collection $upstream, String $field_name = 'media'): void
    {
        $importedAirtableIds = $model
            ->media()
            ->pluck('custom_properties')
            ->pluck('airtable_id');

        $upstreamAirtableIds = collect($upstream[$field_name])->pluck('id');

        if ($importedAirtableIds == $upstreamAirtableIds) {
            return;
        }

        // Inserts
        $media = collect($upstream[$field_name])
            ->reject(fn($media) => $importedAirtableIds->contains($media['id']))
            ->map(function ($upstreamMediaItem) use ($model) {
                return $model
                    ->addMediaFromUrl($upstreamMediaItem['url'])
                    ->withCustomProperties([
                        'airtable_id' => $upstreamMediaItem['id'],
                    ])
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });

        // Deletes
        $model
            ->getMedia()
            ->reject(fn(Media $item) => $upstreamAirtableIds->contains($item->getCustomProperty('airtable_id')))
            ->each(fn(Media $media) => $media->delete());

        // Sorting
        $upstreamAirtableIds->each(function ($airtableId, $index) use ($model) {
            $model
                ->media()
                ->where('custom_properties->airtable_id', $airtableId)
                ->update([
                    'order_column' => $index + 1, // medialibrary sorts from 1 by default
                ]);
        });
    }
}
