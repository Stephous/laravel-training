<?php

namespace App\Listeners;

use App\Events\CreateUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class DownloadUserAvatar implements ShouldQueue
{
    // télécharger un photo d'avatar à notre nouvel utilisateur depuis l'API UI-Avatar sur une queue nommée avatar de manière asynchrone
    public $queue = 'avatar';
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateUser $event): void
    {
        $name = $event->name;
        $this->downloadAvatar($name);
    }
    private function downloadAvatar(string $name): bool
    {
        $url = "https://ui-avatars.com/api/?name=" . urlencode($name);
        $avatar = file_get_contents($url);
        return Storage::put("avatars/{$name}.png", $avatar);
    }
}
