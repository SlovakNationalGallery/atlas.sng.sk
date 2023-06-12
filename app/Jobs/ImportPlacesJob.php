<?php

namespace App\Jobs;

use App\Models\Place;
use App\Models\Exhibition;
use Illuminate\Support\Arr;
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

        $exhibition_ids = Exhibition::all()->pluck('id');

        $places = \Airtable::table('places')
            ->all()
            ->pipe(fn($places) => $mapper->mapTable($places, 'places', false));
            
        DB::transaction(function () use ($places, $exhibition_ids) {
            $missing_ids = Place::whereNotIn('id', $places->pluck('id'))
                ->get()
                ->pluck('id');
            Place::destroy($missing_ids);

            $places->each(function ($upstreamPlace) use ($exhibition_ids) {
                $place = Place::updateOrCreate(
                    ['id' => $upstreamPlace['id']],
                    $upstreamPlace->except(['media', 'exhibition'])->toArray()
                );
                $place->save();

                // save exhibition
                if ($place->code && $exhibition_ids->contains($upstreamPlace['exhibition'])) {
                    $place->code->exhibition_id = $upstreamPlace['exhibition'];
                    $place->code->save();
                }

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
                    ->reject(fn($media) => $importedAirtableIds->contains($media['id']))
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
