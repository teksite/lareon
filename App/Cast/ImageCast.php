<?php

namespace Lareon\CMS\App\Cast;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;


class ImageCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        // Add your "get" logic here
      if ($value){
          if (request()->routeIs('admin.*')){
              return $value;
          }else{
              return  str_starts_with($value , config('app.url')) ? $value : url($value);
          }
      }
      return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        // Add your "set" logic here
        return $value;
    }
}
