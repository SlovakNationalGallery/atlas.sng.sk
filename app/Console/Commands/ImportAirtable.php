<?php

namespace App\Console\Commands;

use Airtable;
use App\Models\Code;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class ImportAirtable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:airtable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from airtable';

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
        $records = Airtable::table('default')
            ->where('ID', '!=', '')
            ->get();
        $bar = $this->output->createProgressBar(count($records));
        $bar->start();
        $records->each(function ($record) use (&$bar) {
            $bar->advance();
            $item_id = $record['fields']['ID'];
            $code = Code::firstOrNew([
                'item_id' => $item_id,
            ]);
            if (!$code->exists) {
                $code->code = Code::randomUniqueCode();
            }

            $code->airtable_id = $record['id'];

            $code->description = [
                'sk' => Arr::get($record, 'fields.app text'),
                'en' => Arr::get($record, 'fields.app text preklad'),
            ];

            $code->author_name = [
                'sk' => Arr::get($record, 'fields.Autor/ka'),
                'en' => Arr::get($record, 'fields.Autor/ka EN'),
            ];

            $code->author_description = [
                'sk' => Arr::get($record, 'fields.Autor text SK'),
                'en' => Arr::get($record, 'fields.Autor text EN'),
            ];

            $code->offset_top = Arr::get($record, 'fields.offsetTop', 0);

            $code->save();
            // update code in airtable
            if (\App::environment('production') && (empty($record['fields']['code']) || $record['fields']['code'] != $code->code)) {
                Airtable::table('default')->patch($record['id'], ['code' => $code->code]);
            }
        });

        $bar->finish();
        $this->newLine();
        $this->info('Done 🎉');
    }
}
