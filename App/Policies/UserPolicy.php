<?php

namespace Lareon\CMS\App\Policies;

use Illuminate\Auth\Access\Response;
use Lareon\CMS\App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $client): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $client): Response
    {
        return $this->check($user,$client);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $client): Response
    {
        return $this->check($user,$client , 'you cannot delete this user');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $client): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $client): bool
    {
        return false;
    }

    protected function check(User $user, User $client ,string $message = 'you cannot edit this user'): Response
    {
        if ($client->hasRole(['admin','owner','administrator'])){
            if (!$user->hasRole(['administrator','owner'])){
               return  Response::deny($message);
            }
        }
        return Response::allow();
    }
}
