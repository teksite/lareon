<?php

namespace Lareon\CMS\App\Traits;

use Lareon\CMS\App\Models\Permission;
use Lareon\CMS\App\Models\Role;

trait HasAuthorization
{
    public function permissions()
    {
        return $this->morphToMany(Permission::class ,'model' , 'auth_permission_models');
    }

    public function roles()
    {
        return $this->morphToMany(Role::class ,'model' , 'auth_role_models');
    }

    public function syncPermissions(array $permissions , $detaching = true)
    {
        if($detaching) return $this->permissions()->sync($permissions);

        return $this->permissions()->syncWithoutDetaching($permissions);
    }

    public function assignRole(array $roles  , $detaching = true)
    {
        if($detaching) return $this->roles()->sync($roles);

        return $this->roles()->syncWithoutDetaching($roles);
    }




}


