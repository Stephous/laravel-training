<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Invoice;

class TotalAmountUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:total-amount {--id=} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Affiche le montant total des factures d\'un utilisateur';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $id = $this->option('id');
        $email = $this->option('email');
        if ($id) {
            $user = User::find($id);
        } elseif ($email) {
            $user = User::where('email', $email)->first();
        } else {
            $this->error('Vous devez spécifier un id ou un email');
            return;
        }
        if (!$user) {
            $this->error('Aucun utilisateur trouvé');
            return;
        }
        $invoices = Invoice::where('client_id', $user->id)->sum('total_amount');
        $this->info("L'utilisateur $user->name a un total de $invoices €");
    }
}
