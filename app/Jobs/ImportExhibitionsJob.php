<?php

namespace App\Jobs;

use App\DataMappers\AirtableMapper;
use App\Models\Exhibition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportExhibitionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $mapper = app(AirtableMapper::class);

        $exhibitions = \Airtable::table('exhibitions')
            ->all()
            ->pipe(fn($exhibitions) => $mapper->mapTable($exhibitions, 'exhibitions'));

        DB::transaction(function () use ($exhibitions) {
            Exhibition::whereNotIn('id', $exhibitions->pluck('id'))->delete();
            Exhibition::upsert($exhibitions->toArray(), ['id']);
        });
    }
}
