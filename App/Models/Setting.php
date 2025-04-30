<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'state',];

    protected function casts()
    {
        return [
            'value'=>'json'
        ];
    }
}
