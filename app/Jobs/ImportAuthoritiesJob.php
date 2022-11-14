<?php

namespace App\Jobs;

use App\DataMappers\AirtableMapper;
use App\Models\Authority;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ImportAuthoritiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $mapper = app(AirtableMapper::class);
        $idField = $mapper->getField('authorities.id');

        $authorities = \Airtable::table('authorities')
            ->where($idField, '!=', '')
            ->all()
            ->pipe(fn($authorities) => $mapper->mapTable($authorities, 'authorities'));

        DB::transaction(function () use ($authorities) {
            Authority::whereNotIn('id', $authorities->pluck('id'))->delete();
            Authority::upsert($authorities->toArray(), ['id']);
        });
    }
}
