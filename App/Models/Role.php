<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends Model
{
    protected $table='auth_roles';

    protected $fillable =['title', 'description'];

    const rules=[
        'title'=>'required|string|max:255|unique:auth_roles,title',
        'description'=>'nullable|string|max:255',
        'permissions'=>'array|required',
        'permissions.*'=>'exists:auth_permissions,id',
    ];


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'auth_permission_role');
    }

}
