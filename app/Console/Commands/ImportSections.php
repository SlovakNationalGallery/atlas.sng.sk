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
        $records = Airtable::table('sections')->get();
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

            $itemIds = Arr::get($record, 'fields.Diela sekcie', []);
            $section->save();

            $items = Item::whereIn('airtable_id', $itemIds)->get();
            $section->items()->sync($items);

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
