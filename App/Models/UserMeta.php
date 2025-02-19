<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Database\Eloquent\Model;
use Teksite\Extralaravel\Casts\JsonCast;

class UserMeta extends Model
{
    protected $table='user_meta';
    protected $fillable =['key','value'];

    protected function casts()
    {
        return [
            'value'=>JsonCast::class
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
