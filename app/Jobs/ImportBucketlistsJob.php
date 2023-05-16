<?php

namespace App\Jobs;

use App\DataMappers\AirtableMapper;
use App\Models\Bucketlist;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImportBucketlistsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        $records->each(fn($record) => $this->syncMedia(Bucketlist::find($record['id']), $record));
    }

    protected function syncMedia(Model $model, Collection $upstream): void
    {
        $importedAirtableIds = $model
            ->media()
            ->pluck('custom_properties')
            ->pluck('airtable_id');

        $upstreamAirtableIds = collect($upstream['media'])->pluck('id');

        if ($importedAirtableIds == $upstreamAirtableIds) {
            return;
        }

        // Inserts
        collect($upstream['media'])
            ->reject(fn($media) => $importedAirtableIds->contains($media['id']))
            ->each(function ($media) use ($model) {
                $model
                    ->addMediaFromUrl($media['url'])
                    ->withCustomProperties([
                        'airtable_id' => $media['id'],
                    ])
                    ->withResponsiveImages()
                    ->toMediaCollection();
            });

        // TODO Deletes

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
