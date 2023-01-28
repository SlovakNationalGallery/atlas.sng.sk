<?php

namespace App\Jobs;

use App\Models\Place;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\DataMappers\AirtableMapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportPlacesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mapper = app(AirtableMapper::class);

        $places = \Airtable::table('places')
            ->all()
            ->pipe(fn ($places) => $mapper->mapTable($places, 'places'));

        DB::transaction(function () use ($places) {
            Place::whereNotIn('id', $places->pluck('id'))->delete();
            Place::upsert($places->map->except(['media'])->toArray(), ['id']);

            $places->each(function ($upstreamPlace) {
                $place = Place::find($upstreamPlace['id']);

                $importedAirtableIds = $place
                    ->media()
                    ->pluck('custom_properties')
                    ->pluck('airtable_id');

                $upstreamAirtableIds = collect($upstreamPlace['media'])->pluck('id');

                if ($importedAirtableIds == $upstreamAirtableIds) {
                    return;
                }

                // Inserts
                collect($upstreamPlace['media'])
                    ->reject(fn ($media) => $importedAirtableIds->contains($media['id']))
                    ->each(function ($media) use ($place) {
                        $place
                            ->addMediaFromUrl($media['url'])
                            ->withCustomProperties([
                                'airtable_id' => $media['id'],
                            ])
                            ->withResponsiveImages()
                            ->toMediaCollection();
                    });

                // Sorting
                $upstreamAirtableIds->each(function ($airtableId, $index) use ($place) {
                    $place
                        ->media()
                        ->where('custom_properties->airtable_id', $airtableId)
                        ->update([
                            'order_column' => $index + 1, // medialibrary sorts from 1 by default
                        ]);
                });
            });
        });
    }
}
