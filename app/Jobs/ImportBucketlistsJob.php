<?php

namespace App\Jobs;

use App\DataMappers\AirtableMapper;
use App\Models\Bucketlist;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Traits\SyncsMedia;
class ImportBucketlistsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SyncsMedia;

    public function handle()
    {
        $mapper = app(AirtableMapper::class);
        $itemsField = $mapper->getField('bucketlists.items');

        $records = \Airtable::table('bucketlists')
            ->where($itemsField, '!=', '')
            ->all()
            ->pipe(fn($bucketlists) => $mapper->mapTable($bucketlists, 'bucketlists'));

        DB::transaction(function () use ($records) {
            $missing_ids = Bucketlist::whereNotIn('id', $records->pluck('id'))
                ->get()
                ->pluck('id');
            Bucketlist::destroy($missing_ids);

            Bucketlist::upsert($records->map->except(['media', 'items'])->toArray(), ['id']);

            $airtableIds = $records
                ->pluck('items')
                ->collapse()
                ->unique();
            $itemsLookup = Item::whereIn('airtable_id', $airtableIds)->pluck('id', 'airtable_id');

            $records->each(
                fn($record) => Bucketlist::find($record['id'])
                    ->items()
                    ->sync(
                        collect($record['items'])->mapWithKeys(
                            fn($airtableId, $index) => [
                                $itemsLookup[$airtableId] => [
                                    'ord' => $index,
                                ],
                            ]
                        )
                    )
            );
        });

        $records->each(fn($record) => self::syncMedia(Bucketlist::find($record['id']), $record));
    }

}
