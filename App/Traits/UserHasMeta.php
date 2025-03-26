<?php

namespace Lareon\CMS\App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lareon\CMS\App\Models\UserMeta;

trait UserHasMeta
{
    /**
     * Define the relationship with UserMeta
     *
     * @return HasMany
     */
    public function meta(): HasMany
    {
        return $this->hasMany(UserMeta::class);
    }


    /**
     * Retrieve meta data based on key(s)
     *
     * @param string|array<string> $keys Meta key(s) to query ('*' for all)
     * @param string|array<string> $columns Column(s) to select
     * @return mixed Collection|Model|string|null
     */
    public function getMeta(string|array $keys = '*', string|array $columns = ['*'])
    {
        $query = $this->meta();

        // Apply key filtering
        $query = match (true) {
            is_string($keys) && $keys === '*' => $query,
            is_string($keys) => $query->where('key', $keys),
            is_array($keys) => $query->whereIn('key', $keys),
        };

        // Handle single string column with single key
        if (is_string($columns) && is_string($keys) && $keys !== '*') {
            return $query->first()?->$columns;
        }

        // Handle other cases
        return is_string($keys) && $keys !== '*'
            ? $query->first($columns)
            : $query->get($columns);
    }
}
