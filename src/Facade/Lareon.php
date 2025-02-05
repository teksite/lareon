<?php

namespace Teksite\Lareon\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Teksite\Lareon\Services\LareonServices cmsPath(?string $path = null, bool $absolute = true)
 * @method static \Teksite\Lareon\Services\LareonServices cmsNamespace(?string $path = null)
 *
 * @see \Teksite\Module\Services\LareonServices
 */
class Lareon extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Lareon';
    }

}
