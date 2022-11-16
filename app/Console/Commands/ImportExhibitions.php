<?php

namespace App\Console\Commands;

use App\Jobs\ImportExhibitionsJob;
use Illuminate\Console\Command;

class ImportExhibitions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:exhibitions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import exhibitions from airtable';

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
        ImportExhibitionsJob::dispatch();
    }
}
