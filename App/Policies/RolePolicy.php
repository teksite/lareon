<?php

namespace Lareon\CMS\App\Policies;

use Illuminate\Auth\Access\Response;
use Lareon\CMS\App\Models\User;
use Teksite\Authorize\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Role $role): bool
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
    public function update(User $user, Role $role): Response
    {
        return $this->check($user,$role);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Role $role): Response
    {
        return $this->check($user,$role , 'you cannot delete this role');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Role $role): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    }

    protected function check(User $user, Role $role ,string $message = 'you cannot edit this role'): Response
    {
        if (in_array($role->id ,[1,2,3,5])) return Response::deny('this role is protected');
        if($user->roles()->min('hierarchy') > $role->hierarchy) return Response::deny('you cannot edit this role');
        return Response::allow();
    }
}
