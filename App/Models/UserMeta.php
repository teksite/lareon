<?php

namespace Lareon\CMS\App\Models;

use Illuminate\Database\Eloquent\Model;
use Teksite\Extralaravel\Casts\JsonCast;

class UserMeta extends Model
{
    protected $table = 'user_meta';
    protected $fillable = ['key', 'value', 'status',];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    protected function casts(): array
    {
        return [
            'value' => JsonCast::class,
        ];
    }
    /**
     * @return string[]
     */
    protected function rules(): array
    {
        return [
            'key' => 'required|string|max:30',
            'value' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }


}
