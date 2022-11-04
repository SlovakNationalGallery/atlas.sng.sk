<?php

namespace App\Console\Commands;

use Airtable;
use App\Models\Item;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import items from airtable';

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
        $records = Airtable::table('items')
            ->where('ID', '!=', '')
            ->get();
        $bar = $this->output->createProgressBar(count($records));
        $bar->start();
        $records->each(function ($record) use (&$bar) {
            $bar->advance();
            $item = Item::unguarded(
                fn() => Item::firstOrNew([
                    'id' => $record['fields']['ID'],
                ])
            );

            $item->airtable_id = $record['id'];

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

            $item->offset_top = Arr::get($record, 'fields.offsetTop', 0);

            $item->save();

            // update code in airtable
            if (
                \App::environment('production') &&
                (empty($record['fields']['code']) || $record['fields']['code'] != $item->code->code)
            ) {
                Airtable::table('items')->patch($record['id'], ['code' => $item->code->code]);
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info('Done 🎉');
    }
}
