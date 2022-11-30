<?php

namespace App\Console\Commands;

use Airtable;
use App\Models\Item;
use App\Models\Section;
use App\Models\Exhibition;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportSections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import sections from airtable';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exhibition_ids = Exhibition::all()->pluck('id');
        $records = Airtable::table('sections')->all();
        $bar = $this->output->createProgressBar(count($records));
        $bar->start();
        $records->each(function ($record) use ($bar, $exhibition_ids) {
            $bar->advance();

            $section = Section::unguarded(
                fn() => Section::firstOrNew([
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

            $section->save();

            $airtableIds = Arr::get($record, 'fields.Diela sekcie', []);
            $itemsLookup = Item::whereIn('airtable_id', $airtableIds)->pluck('id', 'airtable_id');
            $section->items()->sync(
                collect($airtableIds)->mapWithKeys(
                    fn($airtableId, $index) => [
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

            if (
                \App::environment('production') &&
                (empty($record['fields']['code']) || $record['fields']['code'] != $section->code->code)
            ) {
                Airtable::table('sections')->patch($record['id'], ['code' => $section->code->code]);
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info('Done 🎉');
    }
}
