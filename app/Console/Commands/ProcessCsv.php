<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessCsvJob;

class ProcessCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process csv file';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        ProcessCsvJob::dispatch()->onQueue('file_processing');
        $this->info('Job dispatched');
    }
}
