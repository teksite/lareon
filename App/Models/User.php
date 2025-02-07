<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Lareon\CMS\Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'phone', 'password', 'featured_image', 'telegram_id' ,'parent_id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ['password', 'remember_token', 'telegram_id'];

    /**
     *  Change User Factor
     *
     * @return UserFactory|Factory
     */
    protected static function newFactory(): UserFactory|\Illuminate\Database\Eloquent\Factories\Factory
    {
        return UserFactory::new();
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markPhoneAsVerified()
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->public_id = (string)Str::ulid();
        });
    }

    public function permissions()
    {
        return $this->morphToMany(Permission::class, 'model', 'auth_permission_models');

    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'auth_role_models');
    }

    public function syncPermissions(array $permissions, $detaching = true)
    {
        if ($detaching) return $this->permissions()->sync($permissions);

        return $this->permissions()->syncWithoutDetaching($permissions);
    }

    public function assignRole(array $roles, $detaching = true)
    {
        if ($detaching) return $this->roles()->sync($roles);

        return $this->roles()->syncWithoutDetaching($roles);
    }



    public function hasRole(string|int|array|Role|Collection $roles): bool
    {
        if (is_int($roles)) {
            $roles = Role::query()->where('title', $roles)->first('id');
        }

        if (is_int($roles)) {
            $roles = Role::find($roles);
        }

        if ($roles instanceof Role) {
            $roles = Role::query()->find($roles ,'id');
        }
        return !!$roles->intersect($this->roles->pluck('id'))->all();
    }
    public function hasPermission(string|int|Permission $permission): bool
    {
        if (is_string($permission)) {
            $permission = Permission::query()->where('title', $permission)->with('roles')->first('id');
        }
        if ($permission instanceof Permission) {
            $permission = $permission->with('roles')->first();
        }
        return $this->permissions->contains('id', $permission->id) || $this->hasRole($permission->roles);
    }
}
