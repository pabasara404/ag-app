<?php

namespace App\Policies;

use App\Models\OtherPartneredBusiness;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OtherPartneredBusinessPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, OtherPartneredBusiness $otherPartneredBusiness): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, OtherPartneredBusiness $otherPartneredBusiness): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OtherPartneredBusiness $otherPartneredBusiness): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OtherPartneredBusiness $otherPartneredBusiness): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OtherPartneredBusiness $otherPartneredBusiness): bool
    {
        //
    }
}
