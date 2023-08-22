<?php

namespace App\Jobs;

use Airtable;
use App\Models\Item;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Arr;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportItemsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $item_ids = [];
        $records = Airtable::table('items')
            ->where('Publikovať', true)
            ->all();
        $records->each(function ($record) use (&$item_ids) {
            $item_ids[] = $record['fields']['ID'];

            $item = Item::unguarded(
                fn() => Item::firstOrNew([
                    'id' => $record['fields']['ID'],
                ])
            );

            $item->airtable_id = $record['id'];

            $item->title = Arr::get($record, 'fields.Názov diela');

            $item->description = [
                'sk' => Arr::get($record, 'fields.app text'),
                'en' => Arr::get($record, 'fields.app text preklad'),
            ];

            $item->author_name = [
                'sk' => Arr::get($record, 'fields.Autor/ka'),
                'en' => Arr::get($record, 'fields.Autor/ka EN'),
            ];

            $item->author_description = [
                'sk' => Arr::get($record, 'fields.Autor text SK'),
                'en' => Arr::get($record, 'fields.Autor text EN'),
            ];

            $item->locked_bucketlist_description = [
                'sk' => Arr::get($record, 'fields.Bucketlist locked text SK'),
                'en' => Arr::get($record, 'fields.Bucketlist locked text EN'),
            ];

            $item->offset_top = Arr::get($record, 'fields.offsetTop', 0);
            $item->video = Arr::get($record, 'fields.Video URL');

            $item->video_title = [
                'sk' => Arr::get($record, 'fields.Video title SK'),
                'en' => Arr::get($record, 'fields.Video title EN'),
            ];

            $item->video_subtitle = [
                'sk' => Arr::get($record, 'fields.Video subtitle SK'),
                'en' => Arr::get($record, 'fields.Video subtitle EN'),
            ];

            $item->story_id = Arr::get($record, 'fields.Story node.0');
            $item->location_id = Arr::get($record, 'fields.Lokácia.0');

            $item->save();

            if ($item->code) {
                $item->code->exhibition_id = Arr::get($record, 'fields.Výstava.0');
                $item->code->save();
            }
        });

        $missing_ids = Item::whereNotIn('id', $item_ids)
            ->get()
            ->pluck('id');
        Item::destroy($missing_ids);
    }
}
