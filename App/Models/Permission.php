<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Permission extends Model
{
    protected $fillable=['title','description'];

    protected $table ='auth_permissions';

    const rules =[
        'title'=>'required|string|max:255|unique:auth_permissions,title',
        'description'=>'nullable|string|max:255',
    ];

    public function roles()
    {
        return $this->belongsToMany(role::class, 'auth_permission_role');
    }

}
