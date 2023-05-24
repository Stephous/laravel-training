<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\JobProcessCsv;

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
        $filePath = 'app/csv/data.csv';
        var_dump($filePath); // Affiche le contenu de la variable $filepath dans la console
        JobProcessCsv::dispatch($filePath)->onQueue('file_processing');
        $this->info('Job dispatched');
    }
}
