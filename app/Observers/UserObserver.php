<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    // permet de logger la création d'un nouvel utilisateur en base de données. Nous vous logger uniquement la création d'un utilisateur. On utilisera l'instruction Log::info() qui contiendra l'email de l'utilisateur nouvellement créé.
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        Log::info("Un nouvel utilisateur a été créé : {$user->email}");
        // log stocké dans storage/logs/laravel.log
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
