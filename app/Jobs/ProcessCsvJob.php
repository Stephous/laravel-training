<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Enums\Roles;

class ProcessCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $csvFilePath = 'csv/data.csv';
        $csvData = $this->readCsv(storage_path('app/' . $csvFilePath));
        foreach ($csvData as $key => $value) {
            // if first line, skip or if email already exists
            if ($key === 0) {
                continue;
            }
                        
            $user = User::where('email', $value[1])->first();
            if (!$user) {
                User::create([
                    'name' => $value[0],
                    'email' => $value[1],
                    'role' => 'client',
                ]);
            }
        }
    }
    private function readCsv(string $path): array {
        $file = fopen($path, 'r');
        $data = [];
        while (($line = fgetcsv($file)) !== false) {
            $data[] = $line;
        }
        fclose($file);
        return $data;
    }
}
