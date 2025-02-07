<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends Model
{
    protected $table='auth_roles';

    protected $fillable =['title', 'description'];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'auth_permission_role');
    }

}
