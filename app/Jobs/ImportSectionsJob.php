<?php

namespace App\Jobs;

use App\DataMappers\AirtableMapper;
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
use App\Traits\SyncsMedia;
class ImportSectionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SyncsMedia;

    public function handle()
    {
        $mapper = app(AirtableMapper::class);
        $records = \Airtable::table('sections')
            ->where('Publikovať', true)
            ->all()
            ->pipe(fn($sections) => $mapper->mapTable($sections, 'sections', false));

        $records->each(function ($record) {
            $section = Section::updateOrCreate(
                ['id' => $record['id']],
                $record->except(['media', 'exhibition'])->toArray()
            );
            $section->save();

            $airtableIds = $record['items'];
            $itemsLookup = $airtableIds ? Item::whereIn('airtable_id', $airtableIds)->pluck('id', 'airtable_id') : collect();
            $section->items()->sync(
                collect($airtableIds)
                ->filter(fn($airtableId) => $itemsLookup->has($airtableId))                
                ->mapWithKeys(
                    fn ($airtableId, $index) => [
                        $itemsLookup[$airtableId] => [
                            'ord' => $index,
                        ],
                    ]
                )
            );

            if ($section->code) {
                $section->code->exhibition_id = $record['exhibition'];
                $section->code->save();
            }

            self::syncMedia($section, $record);
        });

        // remove the remaining sections and detach relations with related items
        $missing_ids = Section::whereNotIn('id', $records->pluck('id'))->get()->pluck('id');
        Section::destroy($missing_ids);
    }
}
