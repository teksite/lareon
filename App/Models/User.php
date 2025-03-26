<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lareon\CMS\App\Traits\UserHasMeta;
use Lareon\CMS\Database\Factories\UserFactory;
use Teksite\Authorize\Models\Role;
use Teksite\Authorize\Traits\HasAuthorization;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable , HasAuthorization ,UserHasMeta;

    protected static function newFactory(): UserFactory|Factory
    {
        return UserFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['parent_id', 'slug', 'name', 'nick_name', 'email', 'phone', 'telegram_id', 'featured_image', 'email_verified_at', 'phone_verified_at', 'password',];


    /**
     * @return string[]
     */
    static function rules(): array
    {
        return [
            'parent_id'=>'nullable|int',
            'name'=>'required|string|max:255',
            'nick_name'=>'nullable|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'phone'=>'required|string|max:11',
            'telegram_id'=>'nullable|string|max:255',
            'featured_image'=>'nullable|string|max:255',
            'password'=>'required|string|min:8',
        ];
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'telegram_id'
    ];

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
     * @return bool
     */
    public function markPhoneAsVerified(): bool
    {
        return $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * @return BelongsTo|null
     */
    public function parent(): ? BelongsTo
    {
       return $this->parent_id ? $this->belongsTo(self::class, 'parent_id') : null;
    }


}
