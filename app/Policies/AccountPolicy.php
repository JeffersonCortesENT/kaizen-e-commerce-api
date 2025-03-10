<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Account;

class AccountPolicy
{
    /**
     * Determine if the account is enabled.
     */
    public function canLogin(Account $account): bool
    {
        return (bool) $account->enabled; // Check if the account is enabled
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?Account $user, Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(?Account $user, Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(?Account $user, Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(?Account $user, Account $account): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(?Account $user, Account $account): bool
    {
        return false;
    }
}
