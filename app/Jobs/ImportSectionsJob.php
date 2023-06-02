<?php

namespace App\Jobs;

use Airtable;
use App\Models\Item;
use App\Models\Section;
use App\Models\Exhibition;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Arr;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportSectionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $exhibition_ids = Exhibition::all()->pluck('id');
        $records = Airtable::table('sections')->where('Publikovať', true)->get();
        $records->each(function ($record) use ($exhibition_ids) {
            $section = Section::unguarded(
                fn () => Section::firstOrNew([
                    'id' => $record['id'],
                ])
            );

            $section->title = [
                'sk' => Arr::get($record, 'fields.Názov sekcie'),
                'en' => Arr::get($record, 'fields.Názov sekcie EN'),
            ];

            $section->description = [
                'sk' => Arr::get($record, 'fields.Text sekcie'),
                'en' => Arr::get($record, 'fields.Text sekcie EN'),
            ];

            $section->location_id = Arr::get($record, 'fields.Lokácia.0');
            $section->save();

            $airtableIds = Arr::get($record, 'fields.Diela sekcie', []);
            $itemsLookup = Item::whereIn('airtable_id', $airtableIds)->pluck('id', 'airtable_id');
            $section->items()->sync(
                collect($airtableIds)->mapWithKeys(
                    fn ($airtableId, $index) => [
                        $itemsLookup[$airtableId] => [
                            'ord' => $index,
                        ],
                    ]
                )
            );

            if ($section->code && $exhibition_ids->contains(Arr::get($record, 'fields.Výstava.0'))) {
                $section->code->exhibition_id = Arr::get($record, 'fields.Výstava.0');
                $section->code->save();
            }
        });

        // remove the remaining sections and detach relations with related items
        $missing_ids = Section::whereNotIn('id', $records->pluck('id'))->get()->pluck('id');
        Section::destroy($missing_ids);
    }
}
