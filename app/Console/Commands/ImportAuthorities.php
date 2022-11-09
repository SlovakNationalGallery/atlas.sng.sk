<?php

namespace App\Console\Commands;

use App\Jobs\ImportAuthoritiesJob;
use Illuminate\Console\Command;

class ImportAuthorities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:authorities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import authorities from airtable';

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
        ImportAuthoritiesJob::dispatch();
    }
}
