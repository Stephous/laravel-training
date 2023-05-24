<?php

namespace App\Policies;

use App\Models\User;

class InvoicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function before(User $user)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }
    public function viewAny(User $user, Invoice $invoice)
    {
        // return $user->isSuperAdmin() || $user->isAdmin();
        return $user->isAdmin();
    }
    public function view(User $user, Invoice $invoice)
    {
        // return $user->isSuperAdmin() || $user->isAdmin();
        return $user->isAdmin();
    }
    public function create(User $user, Invoice $invoice)
    {
        // return $user->isSuperAdmin() || $user->isAdmin();
        return $user->isAdmin();
    }
    public function destroy(User $user, Invoice $invoice)
    {
        return $user->isSuperAdmin();
    }
}
