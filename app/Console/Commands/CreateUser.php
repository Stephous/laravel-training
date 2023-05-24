<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un utilisateur';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $role = $this->option('role');
        if ($role) {
            $userRole = $role;
        } else {
            $userRole = $this->confirm('Voulez-vous créer un utilisateur avec le rôle client ?') ? 'client' : 
                $this->choice('Quel est le rôle de l\'utilisateur ?', ['client', 'admin', 'super_admin'], 0);
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->role = $userRole;
        $user->save();
        $this->info("L'utilisateur $name a été créé avec le rôle $userRole");
    }
}
