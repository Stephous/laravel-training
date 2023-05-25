<?php

namespace App\Listeners;

use App\Events\CreateUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\User;

class PersistAUser
{
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
        $user = new User();
        $user->name = $event->name;
        $user->email = $event->email;
        $user->role = $event->role;
        $user->save();
    }
}
