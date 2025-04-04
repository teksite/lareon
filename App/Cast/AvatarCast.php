<?php

namespace Lareon\CMS\App\Cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;


class AvatarCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        // Add your "get" logic here
        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // Add your "set" logic here
        return $value;
    }
}
