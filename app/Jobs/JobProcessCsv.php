<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class JobProcessCsv implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $filepath;

    /**
     * Create a new job instance.
     */
    public function __construct(string $filePath)
    {
        $this->filepath = storage_path($filePath);
        var_dump($this->filepath); // Affiche le contenu de la variable $filepath dans la console
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
        $csvData = $this->readCsv($this->filepath);
        foreach ($csvData as $value) {
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
