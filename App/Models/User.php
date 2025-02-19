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
use Lareon\CMS\App\Cast\AvatarCast;
use Lareon\CMS\App\Traits\HasAuthorization;
use Lareon\CMS\Database\Factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable, MustVerifyEmail, HasAuthorization;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'email', 'phone', 'password', 'featured_image', 'telegram_id', 'parent_id'];

    static public function rules(): array
    {
        return [
            "name" => 'string|required|max:255',
            "email" => 'string|email|max:255|unique:users,email',
            "phone" => ['string', 'required', 'unique:users,phone'],
            "password" => 'string|required|min:8|confirmed',
            "featured_image" => 'string|nullable',
            "telegram_id" => 'string|nullable',
            "parent_id" => 'integer|nullable|exists:users,id',
        ];
    }

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
    protected static function newFactory(): UserFactory|Factory
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
            'featured_image' => AvatarCast::class,
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

    public static function hierarchy($min = true, $max = false)
    {
        $hierarchy = [];
        $hierarchy['min'] = auth()->user()->roles()->min('hierarchy');
        $hierarchy['max'] = auth()->user()->roles()->max('hierarchy');
        if ($min && $max === false) {
            return $hierarchy['min'];
        } elseif ($min === false && $max) {
            return $hierarchy['max'];
        }
        return $hierarchy;
    }

    public function meta()
    {
        return $this->hasMany(UserMeta::class);
    }
    public function info(array|string|null $key=null)
    {
        $allInfo= $this->meta()->firstWhere('key','info');
        $infoData=$allInfo->value;
        if(count($infoData)){
            if (is_null($key)) return $infoData;
            $key= is_array($key) ? $key : [$key];
            $data=[];
            foreach ($key as $ky){
                $data[$ky]=$infoData[$ky];
            }
            return $data;
        }
        return null;
    }

}
