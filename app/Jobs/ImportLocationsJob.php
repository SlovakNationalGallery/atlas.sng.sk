<?php

namespace App\Jobs;

use App\Models\Location;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\DataMappers\AirtableMapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ImportLocationsJob implements ShouldQueue
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

        $locations = \Airtable::table('locations')
            ->all()
            ->pipe(fn($locations) => $mapper->mapTable($locations, 'locations'));

        DB::transaction(function () use ($locations) {
            Location::whereNotIn('id', $locations->pluck('id'))->delete();
            Location::upsert($locations->toArray(), ['id']);
        });
    }
}
