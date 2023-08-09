<?php

namespace App\Jobs;

use App\Models\Place;
use App\Models\Exhibition;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\DataMappers\AirtableMapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Traits\SyncsMedia;

class ImportPlacesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SyncsMedia;

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
            ->pipe(fn($places) => $mapper->mapTable($places, 'places', false));
            
        DB::transaction(function () use ($places) {
            $missing_ids = Place::whereNotIn('id', $places->pluck('id'))
                ->get()
                ->pluck('id');
            Place::destroy($missing_ids);

            $places->each(function ($upstreamPlace) {
                $place = Place::updateOrCreate(
                    ['id' => $upstreamPlace['id']],
                    $upstreamPlace->except(['media', 'exhibition'])->toArray()
                );
                $place->save();

                // save exhibition
                if ($place->code) {
                    $place->code->exhibition_id = $upstreamPlace['exhibition'];
                    $place->code->save();
                }

                // sync media
                self::syncMedia($place, $upstreamPlace);
            });
        });
    }
}
