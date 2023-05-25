<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\CreateUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

class SendAWelcomeEmail implements ShouldQueue
{
    // envoi un mail de bienvenue à notre nouvel utilisateur sur une queue nommée mails
    public $queue = 'mails';
    
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
        $email = $event->email;
        $name = $event->name;
        Mail::raw("Bravo {$name}, vous faite maintenant partie de notre programme de fidélité !", function (Message $message) use ($email, $name) {
            $message->to($email, $name)
                ->subject('Bienvenue chez nous !');
        });
    }



}
