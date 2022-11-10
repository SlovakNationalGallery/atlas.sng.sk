<?php

namespace App\Console\Commands;

use App\Jobs\ImportStoriesJob;
use Illuminate\Console\Command;

class ImportStories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:stories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import stories from airtable';

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
        ImportStoriesJob::dispatch();
        $this->info('Done 🎉');
    }
}
