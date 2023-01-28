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
        });
    }
}
