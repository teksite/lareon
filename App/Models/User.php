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
use Lareon\CMS\App\Traits\HasAuthorization;
use Lareon\CMS\Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, MustVerifyEmail ,HasAuthorization;

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


}
